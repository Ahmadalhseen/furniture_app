<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Creating a new user
        $user = new User;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $api_token = ";;";
        $user->save();
        // Retrieve the newly created user as an object
        $user_data = User::where('email', $request->email)->first(); // Use first() instead of get()
        // Return the user data as an object
        return response()->json($user, 201,["token"=>$api_token]);
    }
        public function login(Request $request)
        {
            if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
                $user = Auth::user();

                $token = $user->createToken('Personal Access Token')->accessToken;
                return response()->json([
                    'token' => $token,
                    'user_type' => $user->user_type,
                    'user_id'=>$user->id,
                    'user'=>$user,
                ],201);
            } else {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
        }
        public function logout(Request $request)
        {
            $user = Auth::user();
            return response()->json(['message' => 'Successfully logged out']);
        }
        public function user(Request $request)
        {
            return response()->json($request->user());
        }
}
