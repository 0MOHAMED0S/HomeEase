<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class UserAuth extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'email' => 'nullable|email|max:100|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'phone' => 'required|string|max:12|unique:users',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json([
                    'status' => 401,
                    'message' => 'validation error',
                    'errors' => $errors
                ], 401);
            }

            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)],
            ));

            return response()->json([
                'status' => 200,
                'message' => 'User successfully registered',
                'data' => $user,
                'token' => $user->createToken("API TOKEn")->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 401,
                'message' => $th->getMessage(),
            ], 401);
        }
    }
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email|max:100',
                'phone' => 'nullable|string|max:13',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json([
                    'status' => 401,
                    'message' => 'Validation error',
                    'errors' => $errors
                ], 401);
            }

            if ($request->filled('email')) {
                if (!Auth::attempt($request->only('email', 'password'))) {
                    return response()->json([
                        'status' => 401,
                        'message' => 'Email & Password do not match our records',
                    ], 401);
                }
                $user = User::where('email', $request->email)->first();
            } elseif($request->filled('phone')){
                if (!Auth::attempt($request->only('phone', 'password'))) {
                    return response()->json([
                        'status' => 401,
                        'message' => 'Phone & Password do not match our records',
                    ], 401);
                }
                $user = User::where('phone', $request->phone)->first();
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Either email or phone is required'
                ], 401);
            }

            // Check if the user has role 'user'
            if ($user->role !== 'user') {
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized. Only For users .',
                ], 401);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Successfully logged in',
                'data' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 401,
                'message' => $th->getMessage(),
            ], 401);
        }
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Debugging: Check the type of $user
        if (!$user instanceof User) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ], 404);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        // Update user password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully.',
        ]);
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return Response::json([
                    'status' => 'error',
                    'message' => 'User not found.'
                ], 404);
            }

            $user->currentAccessToken()->delete();

            return Response::json([
                'status' => 'success',
                'message' => 'Logged out successfully.'
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error occurred during logout: ' . $e->getMessage());

            return Response::json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function userProfile()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }
}
