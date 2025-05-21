<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function login(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "username" => "required|string",
                "password" => "required|string"
            ]);

            if ($validator->fails()) {
                return response()->json(["errors" => $validator->messages()], 422);
            }

            $user = User::where('username', $request->username)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'The provided credentials are incorrect'], 401);
            }

            $token = $user->createToken($user->username . 'Auth-Token')->plainTextToken;

            return response()->json([
                'message' => 'Login Successful',
                'token_type' => 'Bearer',
                'token' => $token,
                'role' => $user->role,
                'user' => $user,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout Successful'], 200);
        }

        return response()->json(['message' => 'User not authenticated'], 401);
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fName' => 'required|string|max:255',
                'lName' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username|max:255',
                'password' => 'required|string|min:8',
                'role' => 'required|string|in:admin,teacher,student',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()], 422);
            }

            $user = User::create([
                'fName' => $request->fName,
                'lName' => $request->lName,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'image' => $request->file('image') ? $request->file('image')->store('profiles', 'public') : null,
            ]);

            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
