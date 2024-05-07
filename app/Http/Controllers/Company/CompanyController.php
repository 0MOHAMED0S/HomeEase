<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\categorie;
use App\Models\company;
use App\Models\ContractOrder;
use App\Models\HourlyOrder;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(){
        // $users=User::where('role','user')->get();
        // $usersCount=$users->count();
        // $companies=company::get();
        // $companiesCount=$companies->count();
        // $categorie=categorie::get();
        // $categoriesCount=$categorie->count();
        // $HourlyOrder=HourlyOrder::get();
        // $HourlyOrderCount=$HourlyOrder->count();
        // $ContractOrder=ContractOrder::get();
        // $ContractOrderCount=$ContractOrder->count();
        // $ordersCount=$HourlyOrderCount + $ContractOrderCount;
        return view('CompanyDashboard.dashboard');
    }
    public function mycompanies(){
        $auth=auth()->user()->id;
            $companies=company::where('user_id',$auth)->get();
            $categories=categorie::get();

        return view('CompanyDashboard.mycompanies.mycompanies',compact('companies','categories'));
    }

    public function store(request $request){
        $validatedData = $request->validate([
                'name' => 'required|string',
                'numbers' => 'required|numeric',
                'tybe' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nationality' => 'required|string|max:255',
                'categorie_id' => 'required|exists:categories,id',
        ]);
            $image = $request->file('path');
            $imageName = $image->getClientOriginalName();
            $path = $image->storeAs('CompanyImages', $imageName, 'public');

            $company = new company;
            $company->name = $request->name;
            $company->numbers = $request->numbers;
            $company->tybe = $request->tybe;
            $company->description = $request->description;
            $company->price = $request->price;
            $company->nationality = $request->nationality;
            $company->categorie_id = $request->categorie_id;
            $company->user_id=auth()->user()->id;
            $company->status = 'panding';
            $company->path = $path;
            $company->save();

        return redirect()->back()->with('success', 'company stored successfully');
    }

    public function myorders(){
        $auth=auth()->user()->id;
            $companies=company::where('user_id',$auth)->get();
            $categories=categorie::get();
        return view('CompanyDashboard.orders.orders',compact('companies','categories'));
    }

    public function details($id){
        $auth=auth()->user()->id;
            $hourlyorders=HourlyOrder::where('user_id',$auth)->where('company_id',$id)->get();
            $contractorders=ContractOrder::where('user_id',$auth)->where('company_id',$id)->get();
            $company=company::find($id);
        return view('CompanyDashboard.orders.ordersdetails',compact('hourlyorders','contractorders','company'));
    }

}
