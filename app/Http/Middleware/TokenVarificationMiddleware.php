<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVarificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
// $request variable er maddome heder theke token ta pabo then
        $token = $request->header('token');

        // j token ta pelam oi token ta JWTTokent call kore VarifyToken method diye pass korabo
      $result =  JWTToken::VerifyToken($token);

      if($result == 'unauthorized'){
        return response()->json([

            'status' => 'Failed',
            'message'=>'unauthorized'

        ] ,status:401);

      }else
      {

        $request->headers->set('email',$result);

        return $next($request);

      }


    }
}
