<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Models\ContractOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ContractOrders extends Controller
{

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'number_of_months' => 'required|integer|min:1',
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
            $contractOrder = new ContractOrder;
            $contractOrder->number_of_months = $request->number_of_months;
            $contractOrder->city = $request->city;
            $contractOrder->nationality = $request->nationality;
            $contractOrder->company_id = $request->company_id;
            $contractOrder->categorie_id = $request->categorie_id;
            $contractOrder->date = $request->date;
            $contractOrder->time = $request->time;
            $contractOrder->user_id = $userId;
            $contractOrder->status = 'pending';
            $contractOrder->save();

            return response()->json([
                'status' => 200,
                'message' => 'Contract Order Successfully Sent',
                'contract_order' => $contractOrder
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

}
