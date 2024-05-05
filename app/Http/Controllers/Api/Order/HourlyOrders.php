<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Models\HourlyOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HourlyOrders extends Controller
{
    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'Period' => 'required|string|max:255',
                'number_of_hours' => 'required|integer|min:1',
                'nationality' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'company_id' => 'required|exists:companies,id',
                'categorie_id' => 'required|exists:categories,id',
                'date' => 'required|date',
                'time' => 'required|string',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json([
                    'status' => 422,
                    'message' => 'Validation error',
                    'errors' => $errors
                ], 422);
            }

            // Get the authenticated user's ID
            $userId = Auth::id();

            // Create a new contract order
            $HourlyOrder = new HourlyOrder;
            $HourlyOrder->Period = $request->Period;
            $HourlyOrder->number_of_hours = $request->number_of_hours;
            $HourlyOrder->city = $request->city;
            $HourlyOrder->nationality = $request->nationality;
            $HourlyOrder->company_id = $request->company_id;
            $HourlyOrder->categorie_id = $request->categorie_id;
            $HourlyOrder->date = $request->date;
            $HourlyOrder->time = $request->time;
            $HourlyOrder->user_id = $userId;
            $HourlyOrder->status = 'pending';
            $HourlyOrder->save();

            return response()->json([
                'status' => 200,
                'message' => 'Hourly Order Successfully Sent',
                'hourly_order' => $HourlyOrder
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
