<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class AuthController extends Controller
{
    //--register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'profile' => 'required|image|mimes:png,jpg,jpeg,webp',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        } else {
            $path = null;
            if ($request->hasFile('profile')) {
                $profile = $request->file('profile');
                $profile_name = uniqid() . '-' . $request->name . '.' . $profile->getClientOriginalExtension();
                $path = 'profile/' . $profile_name;
                $profile->move(public_path('profile'), $profile_name);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'profile' => $path,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => 200,
                'success' => 'User Create Successfully',
                'user' => $user
            ]);
        }
    }

    //--login 
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        } else {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $token = $user->createToken('token')->plainTextToken;
                return response()->json([
                    'status' => 200,
                    'success' => "Login Successfully",
                    'user' => $user,
                    'token' => $token
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'error' => 'Invalid credentials'
                ]);
            }
        }
    }

    //--user
    public function user()
    {
        $user = Auth::user();
        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => "user not found"
            ]);
        }
    }

    //-- logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 200,
            'message' => "Logout Successfully"
        ]);
    }
}
