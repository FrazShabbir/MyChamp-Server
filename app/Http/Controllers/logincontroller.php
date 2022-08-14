<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use Mail;

class logincontroller extends Controller
{

    public function login(){
            return view('login');
    }

    public function admin_login(Request $Request){
        $admin = admin::all();
        foreach ($admin as $admin) {
            $pass =  $admin->password;
            $id =  $admin->id;
            $mail = $admin->email;
            $name = $admin->username;
        }

        $password = $Request['password'];
        $email = $Request['email'];
        if ($password == $pass && $email == $mail) {
            $data =  $Request->input();

            $Request->session()->put('name',$name);
            $Request->session()->put('id',$id);
            $Request->session()->put('email',$data['email']);
            $Request->session()->put('password',$data['password']);
            
            toastr()->Success('You are successfully login');
            return redirect('/dashbord');

        }
            toastr()->error('Credential Missmatched');
            return redirect()->back();
            // return redirect()->back()->with('message', 'Credential Missmatched!');
           
        
    }
    	
    public function logout(){       
        if (session()->has('name')) {
        	session()->pull('name');
    	}
        toastr()->success('You are successfully logout');
        return redirect('/'); 

    }


    public function profile(){
        if (session()->get('name')) {
            $id = session()->get('id');
            $admin = admin::find($id);
            $data = compact('admin');    
            return view('profile')->with($data);
        }else{
           return redirect('login');

        }
    }


    public function update_profile(Request $Request){
        if (session()->get('name')) {
            $id = session()->get('id');
            $admin = admin::find($id);
            // if ($Request['old_password'] == $admin->password) {
                $admin->username = $Request['username'];
                $admin->email = $Request['email'];
                $admin->password = $admin->password;

                $admin->save();
                toastr()->success('You are successfully updated your profile');
                return redirect()->back();
            // }else{
                // toastr()->error('Please enter correct old password');
            //     return redirect()->back();
            // }    

        }else{
            return redirect('index');

        }

    }    



    public function change_password(){
        if (session()->get('name')) {
            return view('change_password');
        }else{
           return redirect('login');

        }
    }


    public function update_password(Request $Request){
        if (session()->get('name')) {
            $id = session()->get('id');
            $admin = admin::find($id);
            if ($Request['old_password'] == $admin->password) {
                $admin->username = $admin->username;
                $admin->email = $admin->email;
                $admin->password = $Request['new_password'];

                $admin->save();
                toastr()->success('Password is successfully updated');
                return redirect()->back();
            }else{
            // return redirect()->back()->with('message', 'Please enter correct old password!');
                toastr()->error('Please enter correct old password');
                return redirect()->back();
            }    

        }else{
            return redirect('index');

        }

    }



}
