<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentBlogAddress;
use App\Models\Discount;
use App\Models\Group;
use App\Models\ReactionBlogAddress;
use App\Models\Address;
use App\Models\BlogAddress;
use App\Models\FormRegister;
use App\Models\User;
use App\Models\Bookmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class SearchController extends Controller
{
    public function Search(Request $req,$search){
        if($req){
            if($search){
                $user= DB::table('user_travel')
                      -> select ('user_travel.*')
                      -> where('nickname','like','%'.$search.'%')
                      ->get();
                $count1= $user->count();

                $address= DB::table('address')
                 -> select ('address_id','address_name','address_image')
                 -> where('address_name','like','%'.$search.'%')
                 ->orderBy('created_at','desc')
                 ->get();
                foreach($address as $add){
                    $sumvote=DB::table('blog_address')
                                ->select(DB::raw('SUM(blog_address_vote) AS SUMVOTE'))
                                ->where('address_id','=',$add->address_id)
                                ->groupBy('address_id')
                                ->first();
                    $count=BlogAddress::where('address_id','=',$add->address_id)
                                ->count();
                    if($count!=0){
                        $add->vote=$sumvote->SUMVOTE/$count;
                    }else{
                        $add->vote=0;
                    }

                }
                $count2=$address->count();

                if($count1==0 & $count2==0){
                    return response()->json([
                        'status'=>200,
                        'message'=>'Have no result'
                    ]);
                }else{
                    return response()->json([
                        'user'=>$user,
                        'address'=>$address,
                        'status'=>200,
                        'message'=>'the result suitable'
                    ]);
                }

            }else{
                return response()->json([
                    'status'=>400,
                    'message'=>'Search false'
                ]);
            }

        }
    }
}
