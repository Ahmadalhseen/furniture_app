<?php

namespace App\Http\Middleware;
use App\Models\user_token;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user_token=user_token::where('token',$request->header('token'))->first();
        if($user_token==null)
        {
          return response()->json(["message"=>"unauthinticated"], 401);
        }
       else {
        return $next($request);
       }
    }
}
