<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Models\ContractOrder;
use App\Models\HourlyOrder;
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
                'address' => 'required|string|max:255',
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
            $contractOrder->address = $request->address;
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

    public function ContractOrderDetails($id){
        try {
            $auth=auth()->user()->id;
            $ContractOrder = ContractOrder::where('user_id',$auth)->find($id);
            if($ContractOrder){
                return response()->json([
                    'status' => 200,
                    'message' => 'The Contract Order retrieved successfully',
                    'contract_order' => $ContractOrder
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 200,
                    'message' => 'This User Dont Have Contract Order',
                    'contract_order' => null
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function ContractOrder(){
        try {
            $auth=auth()->user()->id;
            $ContractOrder = ContractOrder::where('user_id',$auth)->get();
            $count=count($ContractOrder);
            if( $count>0){
                return response()->json([
                    'status' => 200,
                    'message' => 'The Contract Order retrieved successfully',
                    'count'=>$count,
                    'contract_order' => $ContractOrder
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 200,
                    'message' => 'This User Dont Have Contract Order',
                    'contract_order' => null
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function AllOrders(){
        try {
            $auth = auth()->user()->id;

            // Get Contract Orders
            $contractOrders = ContractOrder::where('user_id', $auth)->get();

            // Get Hourly Orders
            $hourlyOrders = HourlyOrder::where('user_id', $auth)->get();

            $allOrders = [
                'contract_orders' => $contractOrders,
                'hourly_orders' => $hourlyOrders
            ];

            return response()->json([
                'status' => 200,
                'message' => 'All orders retrieved successfully',
                'all_orders' => $allOrders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
