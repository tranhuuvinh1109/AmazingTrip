<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Auth;
class AuthController extends Controller
{
    // sign up
    public function signUp(Request $req ){
        $user= new User();

        $user->username = $req->username;
        $user->password = bcrypt($req->password);
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->address =  $req->address;
        $user->nickname = $req->nickname;
        $user->birthday = $req->birthday;
        $user->role = $req->role;
        $user->avatar = $req->avatar;
        
        if($user->save()){
            return response()->json([
                'status'=>200,
                'message'=>'Sign up success'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'Sign up false'
            ]);                    
        }
    }

    public function Login(Request $request){
        //$phone=Input::get('phone');
        //$password= Input::get('password');
        $arr = [
            'phone'=> $request->phone, 'password'=> $request->password
        ];
        if(Auth::attempt($arr)){
            $profile = Auth::user();
            return response()->json([
                'status' => 200,
                'user'=> $profile,
                'message' => 'Login successfully'
            ]);
        }else
        {
            return response()->json([
                'status' => 400,
                'message' => 'Phone or Password incorrect'
            ]);
        }
    }
}
