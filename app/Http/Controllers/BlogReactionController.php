<?php

namespace App\Http\Controllers;

use App\Models\ReactionBlog;
use Illuminate\Http\Request;

class BlogReactionController extends Controller
{
    //
    public function reactionUpdate(Request $request){
        $react = ReactionBlog::where('blog_id', $request->blog_id)->where('id_user', $request->id_user)->first();
        if($react) {
            $react->reaction = $request->reaction;
            $react->save();
            return response()->json([
                'data'=> ReactionBlog::all(),
                'status'=>200,
                'message'=>'reacted'
            ]);
        } else {
            $react = new ReactionBlog();
            $react->blog_id = $request->blog_id;
            $react->id_user = $request->id_user;
            $react->reaction = $request->reaction;
            $react->save();
            return response()->json([
                'data'=> ReactionBlog::all(),
                'status'=>200,
                'message'=>'reacted'
            ]);
        }
    }

    public function reactionCheck($blog_id, $id_user){
        $react = ReactionBlog::where('blog_id', $blog_id)->where('id_user', $id_user)->first();
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
    public function unReaction($blog_id, $id_user){
        $react = ReactionBlog::where('blog_id', $blog_id)->where('id_user', $id_user)->first();
        if($react->delete()) {
            return response()->json([
                'data'=> [],
                'status'=>200,
                'message'=>'UnReacte Success'
            ]);
        } else {
            return response()->json([
                'data'=> [],
                'status'=>400,
                'message'=>'Not UnReact'
            ]);
        }
    }
}
