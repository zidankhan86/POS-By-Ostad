<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken{

   public static function CreateToken($userEmail):string{

        $key = env('JWT_KEY');

        $payload = [

            'iss'=>'laravel-token',
            'iat'=>time(),
            'time'=>time()+60-60,
            'userEmail'=>$userEmail,

        ];

    return JWT::encode($payload ,$key,'HS256');

    }


   public static function VerifyToken():string{

        try{

            $key = env('JWT_KEY');
            $decode = JWT::decode($key , new Key($key , 'HS256'));
            return  $decode->userEmail;

        }
        catch(Exception $e){
            return 'Unauthorized';

        }



    }
}


?>
