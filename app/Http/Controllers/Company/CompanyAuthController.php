<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class CompanyAuthController extends Controller
{
    public function login(){
        return view('auth.companyauth.Login');
    }
    public function register(){
        return view('auth.companyauth.Register');
    }

    public function rstore(Request $request)
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
                return redirect()->back()->withErrors($errors)->withInput();
            }

            $userData = $validator->validated();
            $userData['password'] = bcrypt($request->password);

            $user = User::create($userData);
            $user->role = 'company'; // Add this line to set the status to 'company'
            $user->save();
            // Automatically log in the user after registration if you want
            Auth::login($user);
            return redirect()->route('dashboard')->with('message', 'User successfully registered');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => $th->getMessage()]);
        }
    }
}
