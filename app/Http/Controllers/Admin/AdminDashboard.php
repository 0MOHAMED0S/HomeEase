<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\categorie;
use App\Models\company;
use App\Models\Contact;
use App\Models\ContractOrder;
use App\Models\HourlyOrder;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminDashboard extends Controller
{
    public function index(){
        $users=User::where('role','user')->get();
        $usersCount=$users->count();
        $companies=company::get();
        $companiesCount=$companies->count();
        $categorie=categorie::get();
        $categoriesCount=$categorie->count();
        $HourlyOrder=HourlyOrder::get();
        $HourlyOrderCount=$HourlyOrder->count();
        $ContractOrder=ContractOrder::get();
        $ContractOrderCount=$ContractOrder->count();
        $ordersCount=$HourlyOrderCount + $ContractOrderCount;
        return view('dashboard',compact('usersCount','companiesCount','ordersCount','categoriesCount','companies'));
    }
    public function userstable(){
        $users=User::where('role','user')->get();
        return view('AdminDashboard.users',compact('users'));
    }
    public function categories(){
        $categories=categorie::get();
        return view('AdminDashboard.categories',compact('categories'));
    }
    public function store(request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjusted for images
        ]);
            $image = $request->file('path');
            $imageName = $image->getClientOriginalName();
            $path = $image->storeAs('CategoryImages', $imageName, 'public');

        $categorie = new categorie;
        $categorie->name = $validatedData['name'];
        $categorie->path = $path;
        $categorie->save();
        return redirect()->back()->with('success', 'category stored successfully');
    }

    public function delete($id){
        $categorie = categorie::find($id);
        // Check if the product exists
        if (!$categorie) {
            return redirect()->back()->with('error', 'category Not Found');
        }

        // Proceed with the deletion
        $categorie->delete();
        return redirect()->back()->with('success', 'category Deleted successfully');
    }

    public function updateCategory(request $request,$id){
        $categorie = categorie::find($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
            'path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjusted for images
        ]);
        if ($request->file('path')) {
            $image = $request->file('path');
            $imageName = $image->getClientOriginalName();
            $path = $image->storeAs('CategoryImages', $imageName, 'public');
        } else {
            $path = $categorie->path;
        }
        $categorie =categorie::find($id);
        $categorie->name = $validatedData['name'];
        $categorie->path = $path;
        $categorie->save();
        return redirect()->back()->with('success', 'category Updated successfully');
    }

    public function companies(){
        $companies=company::get();
        return view('AdminDashboard.company.companies',compact('companies'));
    }
    public function updateCompany(request $request,$id){
        $company = company::find($id);

        $validatedData = $request->validate([
            'status' => 'required|string|max:25',
        ]);
        $company =company::find($id);
        $company->status = $validatedData['status'];
        $company->save();
        return redirect()->back()->with('success', 'Company Status Updated successfully');
    }

    public function orders(){
        $HourlyOrders=HourlyOrder::get();
        $ContractOrders=ContractOrder::get();
        return view('AdminDashboard.orders.orders',compact('ContractOrders','HourlyOrders'));
    }

    public function profile(){
        return view('AdminDashboard.profile.profile');
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
    public function messages(){
        $messages=Contact::get();
        return view('AdminDashboard.messages.messages',compact('messages'));
    }


}
