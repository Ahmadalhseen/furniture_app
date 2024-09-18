<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\user_token;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Creating a new user
        $user = new User;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password =  Hash::make($request->password);
        $user->save();
        $user_data = User::where('email', $request->email)->first();
        $api_token = Str::random(60);
        $user_token=new user_token();
        $user_token->user_id=$user_data->id;
        $user_token->token=$api_token;
        $user_token->save();
        return response()->json($user, 201,["token"=>$user_token->token]);
    }
        public function login(Request $request)
        {
            if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
                $user = Auth::user();
                $token = Str::random(60);
                $user_token=user_token::where('user_id',$user->id)->first();
                $user_token->user_id=$user->id;
                $user_token->token=$token;
                $user_token->save();
                return response()->json([

                    'user'=>$user,
                ],201,[ 'token' => $token]);
            } else {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
        }
        public function logout(Request $request)
        {
            $user = Auth::user();
            $user_token=user_token::where('user_id',$user->id)->delete();
            return response()->json(['message' => 'Successfully logged out']);
        }
        public function user(Request $request)
        {
            return response()->json($request->user());
        }
}
