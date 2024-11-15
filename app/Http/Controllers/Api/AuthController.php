<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
                $profile_name = uniqid() . '-' . $request->name . '.webp';
                // Get the original dimensions of the image
                list($width, $height) = getimagesize($profile);
                // Set the new dimensions for resizing
                $new_width = 150;
                $new_height = 150;
                // Create a new resized image
                $image_p = imagecreatetruecolor($new_width, $new_height);
                // Load the original image from file (GD will automatically detect the format)
                $image = imagecreatefromstring(file_get_contents($profile));
                if ($image === false) {
                    return response()->json(['error' => 'Invalid image file'], 400);
                }
                // Copy and resize the original image into the new image resource
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                // Save the resized image in WebP format
                $path = 'profiles/' . $profile_name;
                $destinationPath = storage_path('app/public/' . $path);
                // Check if the directory exists, if not create it
                if (!is_dir(dirname($destinationPath))) {
                    // Create directory and set permissions (0755)
                    mkdir(dirname($destinationPath), 0755, true);
                }
                // Save the image as WebP
                imagewebp($image_p, $destinationPath);
                // Clear the memory used by the image resources
                imagedestroy($image);
                imagedestroy($image_p);
            }

            // Create the user in the database with the profile image path
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
                $expiresIn = 86400; // 24 hours
                return response()->json([
                    'status' => 200,
                    'success' => "Login Successfully",
                    'user' => $user,
                    'token' => $token,
                    'expiresIn' => $expiresIn,
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
        $profileUrl = asset('storage/'. $user->profile);
        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => $user,
                'profileUrl' => $user,
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
