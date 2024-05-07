<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\categorie;
use App\Models\company;
use App\Models\ContractOrder;
use App\Models\HourlyOrder;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function index(){
        $companies=company::where('user_id',auth()->user()->id)->get();
        $companiesCount=$companies->count();
        return view('CompanyDashboard.dashboard',compact('companiesCount'));
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
        // $auth=auth()->user()->id;
        $company=company::find($id);
        if($company->tybe == 'Hourly'){
            $orders=HourlyOrder::where('company_id',$id)->get();
        }
        else{
            $orders=ContractOrder::where('company_id',$id)->get();
        }
        return view('CompanyDashboard.orders.ordersdetails',compact('orders','company'));
    }
    public function UpdateOrder(Request $request, $id,$od)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|max:25',
        ]);
        $company = company::find($id);

        if ($company->tybe=='Hourly') {
            $hourlyOrder = HourlyOrder::find($od);
            $hourlyOrder->status = $validatedData['status'];
            $hourlyOrder->save();
        } elseif($company->tybe=='Contract') {
            $contractOrder = ContractOrder::find($od);
            $contractOrder->status = $validatedData['status'];
            $contractOrder->save();
        }

        return redirect()->back()->with('success', 'Order Status Updated successfully');
    }
    public function profile(){
        return view('CompanyDashboard.profile.profile');
    }
    public function updateprofile(Request $request){
        $auth = auth()->user()->id;
        $user = User::find($auth);

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'email|max:100',
            'phone' => 'string|max:13',
        ]);

        if ($request->file('path')) {
            $image = $request->file('path');
            $imageName = $image->getClientOriginalName();
            $path = $image->storeAs('Images', $imageName, 'public');

            $userImage = Image::where('user_id', $auth)->first();
            if (!$userImage) {
                $userImage = new Image();
                $userImage->user_id = $auth;
            }
            $userImage->path = $path;
            $userImage->cover = 'null';
            $userImage->save();
        }

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function updatePassword(Request $request) {
        $user = User::find(auth()->id());

        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Check if old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with(['success' => 'The provided old password does not match your current password.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully');
    }
}
