<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function getUsers()
    {
        $users = User::all();
        return response()->json([
            'users' => $users,
            'status' => 200,
            'message' => 'Get users successfully'
        ]);
    }
    public function PostRegister(Request $request){
        if($request){
            $checkEmail = User::where('email',$request->email)->first() ;
            $checkPhone = User::where('phone',$request->phone)->first() ;
            if($checkEmail && $checkPhone){
                return response()->json([
                    'status' => 400,
                    'data'=>$checkPhone,
                    'data2'=>$checkEmail,
                    'message' => 'Phone and email already exists'
                ]);
            }
            if($checkEmail){
                return response()->json([
                    'status' => 401,
                    'data'=>$checkEmail,
                    'data2'=>$checkPhone,
                    'message' => 'Email already exists'
                ]);
            }
            if($checkPhone)
            {
                return response()->json([
                    'status' => 402,
                    'data'=>$checkPhone,
                    'data2'=>$checkEmail,
                    'message' => 'Phone already exists'
                ]);
            }

            else{
                $newUser = new User();
                $data = $request->all();

                $newUser->username = $request->username;
                $newUser->password = bcrypt($request->password);
                $newUser->email = $request->email;
                $newUser->phone = $request->phone;
                $newUser->address =  $request->address;
                $newUser->nickname = $request->nickname;
                $newUser->birthday = $request->birthday;
                $newUser->role = $request->role;
                $newUser->avatar = $request->avatar;
//                if(!empty($avatar))
//                {
//                    $data['avatar'] = $avatar->getClientOriginalName();
//                    $avatar->move('upload/user/avatar',$avatar->getClientOriginalName());
//                    $newUser->avatar = $data['avatar'];
//                    if($newUser->save())
//                    {
//                        return response()->json([
//                            'status' => 200,
//                            'message' => 'Register succesfully'
//                        ]);
//                    }else
//                    {
//                        return response()->json([
//                            'status' => 400,
//                            'message' => 'Register fail'
//                        ]);
//                    }
//
//                }else
//                {
//                    $newUser->avatar = 'default.jpg';
                    if($newUser->save())
                    {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Register succesfully'
                        ]);
                    }else
                    {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Register fail'
                        ]);
                    }
                //}
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data fail'
            ]);
        }
    }
}
