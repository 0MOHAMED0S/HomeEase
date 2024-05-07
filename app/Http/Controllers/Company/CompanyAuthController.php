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
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email|max:100',
                'phone' => 'nullable|string|max:12',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return redirect()->back()->withErrors($errors)->withInput();
            }

            if ($request->filled('email')) {
                if (!Auth::attempt($request->only('email', 'password'))) {
                    return redirect()->back()->withErrors(['email' => 'Email & Password do not match our records']);
                }
                $user = User::where('email', $request->email)->first();
            } elseif ($request->filled('phone')) {
                if (!Auth::attempt($request->only('phone', 'password'))) {
                    return redirect()->back()->withErrors(['phone' => 'Phone & Password do not match our records']);
                }
                $user = User::where('phone', $request->phone)->first();
            } else {
                return redirect()->back()->withErrors(['email' => 'Either email or phone is required']);
            }

            if ($user->role !== 'company') {
                return redirect()->back()->withErrors(['role' => 'Unauthorized. Only for admins.']);
            }
            return redirect()->route('company.dashboard')->with('message', 'Successfully logged in');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => $th->getMessage()]);
        }
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
            return redirect()->route('company.dashboard')->with('message', 'User successfully registered');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => $th->getMessage()]);
        }
    }
}
