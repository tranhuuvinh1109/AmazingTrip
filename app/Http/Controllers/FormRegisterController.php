<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormRegister;
use App\Models\User;

class FormRegisterController extends Controller
{
    public function getRegisterListForAddress($address_id)
    {
        $list = FormRegister::where('address_id', $address_id)->get();
        if($list) {
            foreach($list as $i){
                $user = User::where('id', $i->id_user)->first();
                $i->nickname=$user->nickname;
                $i->avatar=$user->avatar;
            }
            return response()->json([
                'data' =>  $list,
                'status' => 200,
                'message' => 'Get follow successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'doesnt exist'
            ]);
        }
    }
    public function postFormRegister(Request $req)
    {
        if($req){
            $form =  new FormRegister();
            $form->discount_id = $req->input('discount_id');
            $form->id_user = $req->input('id_user');
            $form->quantity_registed = $req->input('quantity_registed');
            if($form->save()){
                $friend = FormRegister::query()
                    ->join('user_travel', 'form_registed.id_user', '=', 'user_travel.id')
                    ->select('user_travel.id',
                        'user_travel.nickname',
                        'user_travel.avatar'
                    )
                    ->where('form_registed.discount_id', '=', $form->discount_id)
                    ->where('form_registed.id_user', '=', $form->id_user)
                    ->first();
                return response()->json([
                    'data' => $friend,
                    'status' => 200,
                    'message' => 'Post Form Register successfully'
                ]);
            }else{
                return response()->json([
                    'data' => $form,
                    'status' => 400,
                    'message' => 'Post Form Register fail'
                ]);
            }
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Post Data false'
            ]);
        }
    }

    public function editFormRegister(Request $req , $id)
    {
        $item = FormRegister::find($id);
        if($req){
            $item->quantity_registed = $req->input('quantity_registed');
            if($item->save()){
                return response()->json([
                    'data' => $item,
                    'status' => 200,
                    'message' => 'Edit Form Register successfully'
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Edit Form Register fail'
                ]);
            }
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Post Data false'
            ]);
        }

    }

    public function deleteFormRegister($discount_id, $id_user)
    {
        $data = FormRegister::query()
            ->where('discount_id', '=', $discount_id)
            ->where('id_user', '=', $id_user)
            ->orderBy('created_at', 'desc')
            ->first();
        if($data){
            if($data->delete()){
                return response()->json([
                    'data' => $data,
                    'status' => 200,
                    'message' => 'Delete Discount successfully'
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Delete Discount false'
                ]);
            }
        }
    }
}
