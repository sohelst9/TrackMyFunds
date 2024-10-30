<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
            return response()->json($validator->errors());
        }

        $path = null;
        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $profile_name = uniqid() . '-' . $request->name . '.' . $profile->getClientOriginalExtension();
            $path = 'profile/' .$profile_name;
            $profile->move(public_path('profile'), $profile_name);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'profile' => $path,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => 'User Create Successfully',
            'user' => $user
        ]);
    }
}
