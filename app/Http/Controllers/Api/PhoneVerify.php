<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Vonage\Client\Credentials\Basic;
use Vonage\Verify\Request as VerifyRequest;
use Vonage\Client;
use Illuminate\Support\Facades\Log;
use Vonage\Client\Exception\Request as VonageRequestException;
use Vonage\Client\Exception\Server as VonageServerException;
class PhoneVerify extends Controller
{
    public function startVerification(Request $request)
    {
        $user = auth()->user();
        $phone = $user->phone;

        $basic = new Basic(
            config('services.slack.vonage.key'),
            config('services.slack.vonage.secret')
        );

        $client = new Client($basic);

        try {
            $verifyRequest = new VerifyRequest($phone, "Power");
            $response = $client->verify()->start($verifyRequest);

            $requestId = $response->getRequestId();

            if (!$requestId) {
                throw new \Exception("Failed to get request ID");
            }

            return response()->json([
                'status' => 200,
                'message' => 'Success: request ID received',
                'request_id' => $requestId,
            ], 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Verification error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkVerification(Request $request)
    {
        $request->validate([
            'register_id' => 'required',
            'code' => 'required',
        ]);

        $registerId = $request->register_id;
        $code = $request->code;

        $basic = new Basic(
            config('services.slack.vonage.key'),
            config('services.slack.vonage.secret')
        );

        $client = new Client($basic);

        try {
            $result = $client->verify()->check($registerId, $code);
            $responseData = $result->getResponseData();

            if ($responseData['status'] === '0') {
                $user = User::where('id', auth()->user()->id)->first();
                if ($user) {
                    $user->email_verified_at = now();
                    $user->save();
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Account verified.',
                    ]);
                }
            }

            // Log failed verification
            Log::warning('Invalid verification code for request ID: ' . $registerId);

            return response()->json([
                'status' => 'error',
                'message' => 'Wrong code or expired.',
            ], 422);
        } catch (VonageRequestException $e) {
            // Log Vonage API request errors
            Log::error('Vonage API request error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Verification failed. Please try again later.',
            ], 500);
        } catch (VonageServerException $e) {
            // Log Vonage API server errors
            Log::error('Vonage API server error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Verification failed. Please try again later.',
            ], 500);
        } catch (\Exception $e) {
            // Log other unexpected errors
            Log::error('Unexpected error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }

    public function cancelVerification(Request $request)
    {
        $registerId = $request->register_id;
        $basic = new Basic(
            config('services.slack.vonage.key'),
            config('services.slack.vonage.secret')
        );

        $client = new Client($basic);

        try {
            $result = $client->verify()->cancel($registerId);
            return response()->json($result->getResponseData());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
