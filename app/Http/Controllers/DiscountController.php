<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount; 
use App\Models\FormRegister;
class DiscountController extends Controller
{
    public function getDiscount()
    {
        $discount = Discount::all();
        return response()->json([
            'data' =>  $discount,
            'status' => 200,
            'message' => 'Get follow successfully'
        ]);
    }
    public function postDiscount(Request $req)
    {
        if($req){
            $discount =  new Discount();
            $discount->address_id = $req->input('address_id');
            $discount->time_start = $req->input('time_start');
            $discount->time_finish = $req->input('time_finish');
            $discount->discount_rate = $req->input('discount_rate');
            $discount->discount_quantity = $req->input('discount_quantity');
            $discount->number_registed = $req->input('number_registed');
            if($discount->save()){
                $data = Discount::all();
                return response()->json([
                    'data' => $data,
                    'status' => 200,
                    'message' => 'Post Discount successfully'
                ]);
            }else{
                return response()->json([
                    'data' => $discount,
                    'status' => 400,
                    'message' => 'Post Discount fail'
                ]);
            }
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Post Data false'
            ]);
        }
    }

    public function editDiscount(Request $req , $id)
    {
        $item = Discount::find($id);
        if($req){
            $item->time_start = $req->input('time_start');
            $item->time_finish = $req->input('time_finish');
            $item->discount_rate = $req->input('discount_rate');
            $item->discount_quantity = $req->input('discount_quantity');
            $item->number_registed = $req->input('number_registed');
            if($item->save()){
                
                return response()->json([
                    'data' => $item,
                    'status' => 200,
                    'message' => 'Edit address successfully'
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Edit address fail'
                ]);
            }
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Post Data false'
            ]);
        }

    }
    
    public function deleteDiscount($id)
    {
        if(Discount::find($id)){
            if(Discount::find($id)->delete()){
                $discount = Discount::all();
                return response()->json([
                    'data' => $discount,
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

    // get discount by each address
    public function getFormDiscount($address_id){
        $discount= Discount::where('address_id',$address_id)->first();
        if($discount){
            
            $registers=FormRegister::where('discount_id',$discount->discount_id)->get();
            foreach($registers as $register){
                $discount->number_registed += $register->quantity_registed;
            }
            
            //$discount->number_registed= FormRegister::where('discount_id',$discount->discount_id)->count('quantity_registed');
            if($discount->save()){
                return response()->json([
                    'data'=>$discount,
                    'status'=>200,
                    'message'=>'get discount form successfull'
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'no discount for  had found'
                ]);
            }
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'no discount for  had found'
            ]);
        }
    }
}
