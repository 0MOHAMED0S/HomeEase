<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class AdminAuthController extends Controller
{
    public function login(){
        return view('auth.adminauth.Login');
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

            if ($user->role !== 'admin') {
                return redirect()->back()->withErrors(['role' => 'Unauthorized. Only for admins.']);
            }
            return redirect()->route('admin.dashboard')->with('message', 'Successfully logged in');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    public function rstore(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:12',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userData = [
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ];

        if ($request->filled('email')) {
            $userData['email'] = $request->email;
        } elseif ($request->filled('phone')) {
            $userData['phone'] = $request->phone;
        } else {
            return redirect()->back()->withErrors(['email' => 'Either email or phone is required'])->withInput();
        }

        $user = User::create($userData);

        return redirect()->route('login')->with('message', 'Registration successful. Please login.');
    } catch (\Throwable $th) {
        return redirect()->back()->withErrors(['error' => $th->getMessage()]);
    }
}
}
