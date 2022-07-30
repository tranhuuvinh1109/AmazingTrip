<?php

namespace App\Http\Controllers;

use App\Models\ReactionBlogAddress;
use Illuminate\Http\Request;

class BlogAddressReactionController extends Controller
{
    public function reactionCheck($blog_address_id, $id_user){
        $react = ReactionBlogAddress::where('blog_address_id', $blog_address_id)->where('id_user', $id_user)->first();
        if($react) {
            return response()->json([
                'data'=> $react,
                'status'=>200,
                'message'=>'Reacted'
            ]);
        } else {
            return response()->json([
                'data'=> [],
                'status'=>400,
                'message'=>'Not React'
            ]);
        }
    }

    public function reactionUpdate(Request $request){
        $react = ReactionBlogAddress::where('blog_address_id', $request->blog_address_id)->where('id_user', $request->id_user)->first();
        if($react) {
            $react->reaction = $request->reaction;
            $react->save();
            return response()->json([
                'data'=> ReactionBlogAddress::all(),
                'status'=>200,
                'message'=>'reacted'
            ]);
        } else {
            $react = new ReactionBlogAddress();
            $react->blog_address_id = $request->blog_address_id;
            $react->id_user = $request->id_user;
            $react->reaction = $request->reaction;
            $react->save();
            return response()->json([
                'data'=> ReactionBlogAddress::all(),
                'status'=>200,
                'message'=>'reacted'
            ]);
        }
    }

    public function unReaction($blog_address_id, $id_user){
        $react = ReactionBlogAddress::where('blog_address_id', $blog_address_id)->where('id_user', $id_user)->first();
        if($react->delete()) {
            return response()->json([
                'data'=> [],
                'status'=>200,
                'message'=>'Reacted'
            ]);
        } else {
            return response()->json([
                'data'=> [],
                'status'=>400,
                'message'=>'Not React'
            ]);
        }
    }
}
