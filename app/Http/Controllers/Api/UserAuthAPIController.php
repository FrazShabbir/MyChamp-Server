<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\admin;
use App\Models\host;
use Mail;

class UserAuthAPIController extends Controller
{
    public function forgetPassword(Request $request)
    {
        $email = $request->email;

        $type = $request->type;
        if ($type == 'admin') {
            $user = admin::where('email', $email)->first();
        } elseif ($type == 'host') {
            $user = host::where('email', $email)->first();
        }

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        } else {
            // send email
            // $otp = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
            // $user->otp = $otp;
            // $user->save();

            $mail = Mail::raw('Your password is '.$user->password.'.', function ($message) use ($email) {
                $message->to($email)
              ->subject('Forget Password');
            });
            return  response()->json([
                'status' => '200',
                 'message' => 'Copy of Password sent to your email.',
                 'email'=>$email,
                ]);
        }
    }




    public function confirm_otp(Request $request)
    {
        $response = [];

        $email = $request->email;
        $otp = $request->otp;
        $type = $request->type;
       
        
        if ($type == 'admin') {
            $user = admin::where('email', $email)->first();
            if ($user->otp==$otp) {
                $response = [
                    'status' => '200',
                    'message' => 'OTP verified',
                    'email'=>$email,
                ];
                return json_encode($response); 
            } else {
                $response = [
                    'status' => '400',
                    'message' => 'OTP not Match',
                    'email'=>$email,
                ];
                return json_encode($response); 
            
            }
        } elseif ($type == 'host') {
            $user = host::where('email', $email)->first();
            if ($user->otp==$otp) {

             $response = [
                    'status' => '200',
                    'message' => 'OTP verified',
                    'email'=>$email,
                ];
                return json_encode($response); 

            } else {
           $response = [
                    'status' => '400',
                    'message' => 'OTP not Match',
                    
                    'email'=>$email,
                ];
                return json_encode($response); 
            }
        }
    }
    public function set_password(Request $request)
    {
        $response = [];

        $email = $request->email;
        $password = $request->password;
        $type = $request->type;

        if ($type == 'admin') {
            $user = admin::where('email', $email)->first();
            $user->password = $password;
            $user->save();
            $response = [
                'status' => '200',
                'message' => 'Password updated',
                'email'=>$email,
            ];
            return json_encode($response);

        } elseif ($type == 'host') {
            $user = host::where('email', $email)->first();
            $user->password = $password;
            $user->save();
            $response = [
                'status' => '200',
                'message' => 'Password updated',
                'email'=>$email,
            ];
            return json_encode($response);
        }
    }
}
