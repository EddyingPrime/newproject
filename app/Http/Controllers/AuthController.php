<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json(['success' => true, 'user' => $user]);
    }

    /**
     * Log in the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;
            return response()->json(['success' => true, 'user' => $user, 'access_token' => $token]);
        }

        return response()->json(['error' => 'Invalid email or password'], 401);
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticatedUser()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json(['success' => true, 'user' => $user]);
        }
    
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    /**
     * Get the authenticated user's profile data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserProfile()
    {
        try {
            $user = Auth::user();
    
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
    
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'profile_image' => $user->profile_image, // Replace with your actual profile picture attribute name
                // Add other fields as needed
            ];
    
            return response()->json(['success' => true, 'user' => $userData], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('Error fetching user profile: ' . $e->getMessage());
    
            return response()->json(['error' => 'Error fetching user profile.'], 500);
        }
    }
    
    /**
     * Update the authenticated user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserProfile(Request $request)
    {
        try {
            $user = Auth::user();
    
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'profilePicture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules for the profile picture
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
    
            $user->name = $request->input('name');
            $user->email = $request->input('email');
    
            if ($request->hasFile('profilePicture')) {
                $profilePicturePath = $request->file('profilePicture')->store('profile_pictures', 'public');
                $user->profile_image = $profilePicturePath; // Update the attribute name accordingly
            }
    
            $user->save();
    
            return response()->json(['success' => true, 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating user profile.'], 500);
        }
    
    }
}