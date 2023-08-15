<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function UserRegistration(Request $request){

        try{
            User::create([

                "firstName"=>$request->input('firstName'),
                "lastName"=>$request->input('lastName'),
                "email"=>$request->input('email'),
                "mobile"=>$request->input('mobile'),
                "password"=>$request->input('password'),


            ]);

            return response()->json([


                'status'=> 'success',
                'message'=>'Registration Success'
            ]);


        }
         catch(Exception $e){

            return response()->json([


                'status'=> 'Failed',
                'message'=>$e->getMessage()
            ]);


         }


    }


    public function UserLogin(Request $request){

          $count = User::where('email','=' ,$request->input('email'))
            ->where('password','=',$request->input('password'))
            ->count();

            if( $count==1){

                //User JWT Token Issue

                $token = JWTToken::CreateToken($request->input('email'));

                return response()->json([
                    'status'=>'success',
                    'message'=>'Login Success',
                    'token'=>$token

                ]);

            }else{

                return response()->json([


                    'status'=> 'Failed',
                    'message'=>'User Unauthorized']);

            }

    }

    public function SendOTPCode(Request $request){

        $email = $request->input('email');
        $otp = rand(1000,9999);
        $count = User::where('email','=',$email)->count();


        if($count == 1 ){

            //Send Email
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email','=',$email)
            ->update(['otp'=>$otp]);

            return response()->json([


                'status'=> 'Success',
                'message'=>'4 Digit OTP Code has been sent to your email ']);

        }else{
            return response()->json([

                'status' => 'Failed',
                'message'=>'Unauthorized'

            ]);
        }

    }

     public function VerifyOTP( Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email','=',$email)
        ->where('otp','=',$otp)
        ->count();

        if($count == 1){

            //Otp Verification Update
            User::where('email','=',$email)
        ->update([ 'otp'=>'0']);

            //token issue for password reset
            $token =JWTToken::CreateTokenForSetPassword( $request->input('emil'));

            return response()->json([

                'status' => 'success',
                'message' => 'Otp Verification has been sent',
                'token' => $token

            ]);

        }else{

            return response()->json([

                'status' => 'Failed',
                'message' =>'Unauthorized'

            ]);
        }


    }

    public function ResetPassword(Request $request){


        try{

            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);

            return response()->json([

                'status' => 'success',
                'message' => 'Request Success'

            ]);

        }catch(Exception $e){

    return response()->json([
        'status' => 'Failed',
        'message' =>' Unauthorized'

    ]);

        }



    }


    //pages

    public function LoginPage(){
        return view('pages.auth.login-page');
    }

    public function RegistrationPage(){
        return view('pages.auth.register-page');
    }

    public function SendOtpPage(){
        return view('pages.auth.send-otp-page');
    }

    public function VerifyOTPPage(){
        return view('pages.auth.verify');
    }

    public function ResetPasswordPage(){
        return view('pages.auth.reset-pass-page');
    }
}
