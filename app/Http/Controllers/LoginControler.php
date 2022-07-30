<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class LoginControler extends Controller
{
    public function PostLogin(Request $request){
        $arr = [
            'phone'=> $request->phone, 'password'=> $request->password,
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
