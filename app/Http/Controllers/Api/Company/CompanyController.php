<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Models\company;
use App\Models\ContractOrder;
use App\Models\HourlyOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'numbers' => 'required|numeric',
                'tybe' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nationality' => 'required|string|max:255',
                'categorie_id' => 'required|exists:categories,id',
            ]);


            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json([
                    'status' => 422,
                    'message' => 'Validation error',
                    'errors' => $errors
                ], 422);
            }

            $image = $request->file('path');
            $imageName = $image->getClientOriginalName();
            $path = $image->storeAs('CpmpanyImages', $imageName, 'public');

            $company = new company;
            $company->name = $request->name;
            $company->tybe = $request->tybe;
            $company->numbers = $request->numbers;
            $company->description = $request->description;
            $company->price = $request->price;
            $company->nationality = $request->nationality;
            $company->categorie_id = $request->categorie_id;
            $company->user_id=auth()->user()->id;
            $company->status = 'active';
            $company->path = $path;
            $company->save();

            return response()->json([
                'status' => 200,
                'message' => 'Company successfully stored',
                'image_path' => $company
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function Company($id){
        try {
            $company = company::find($id);
            if($company){
                return response()->json([
                    'status' => 200,
                    'message' => 'The company retrieved successfully',
                    'company' => $company
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 200,
                    'message' => 'The company Not Found',
                    'company' => null
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function AllCompanies(){
        try {
            $companies = company::where('status','active')->get();

            return response()->json([
                'status' => 200,
                'message' => 'All Active Companies Retrieved Successfully',
                'companies' => $companies
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function HAllCompanies(){
        try {
            $companies = company::where('status','active')->where('tybe','Hourly')->get();

            return response()->json([
                'status' => 200,
                'message' => 'All Active Hourly Companies Retrieved Successfully',
                'companies' => $companies
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function CAllCompanies(){
        try {
            $companies = company::where('status','active')->where('tybe','Contract')->get();

            return response()->json([
                'status' => 200,
                'message' => 'All Active Contract Companies Retrieved Successfully',
                'companies' => $companies
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }


}
