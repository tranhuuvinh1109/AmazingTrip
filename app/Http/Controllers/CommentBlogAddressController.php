<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentBlogAddress;
use App\Models\User;

class CommentBlogAddressController extends Controller
{
    //
    public function getAllCommentBlog ($blog_id){
        $comments = CommentBlogAddress::where('blog_address_id', $blog_id)->orderBy('created_at', 'desc')->get();
        foreach($comments as $comment){
            $commenter = User::where('id', $comment->id_user)->first();
            $comment->nickname=$commenter->nickname;
            $comment->avatar=$commenter->avatar;
        }
        return response()->json([
            'data'=> $comments,
            'status'=>200,
            'message'=>'all comments'
        ]);
    }

    public function createCommentBlog(Request $request, $blog_address_id){
        $comment = new CommentBlogAddress();
        $comment->blog_address_id=$request->blog_address_id;
        $comment->id_user=$request->id_user;
        $comment->comment_address_content= $request->comment_address_content;
        $check = $comment->save();
        $comments = CommentBlogAddress::where('blog_address_id', $blog_address_id)->orderBy('created_at', 'desc')->get();
        foreach($comments as $comment){
            $commenter = User::where('id', $comment->id_user)->first();
            $comment->nickname=$commenter->nickname;
            $comment->avatar=$commenter->avatar;
        }

        if($check){
            return response()->json([
                'data'=> $comments,
                'status'=>200,
                'message'=>'comment success'
            ]);
        } else {
            return response()->json([
                'data'=> $comments,
                'status'=>400,
                'message'=>'comment failed'
            ]);
        }
    }

    public function editCommentBlog(Request $request){
        $comment = CommentBlogAddress::find($request->comment_blog_id);
        if($comment){
            $comment->comment_address_content = $request->comment_blog_content;
            $comments = CommentBlogAddress::where('blog_address_id', $request->blog_id)->get();
            foreach($comments as $cmt){
                $commenter = User::where('id', $comment->id_user)->first();
                $cmt->nickname=$commenter->nickname;
                $cmt->avatar=$commenter->avatar;
            }
            if($comment->save()){
                return response()->json([
                    'data'=> $comments,
                    'status'=>200,
                    'message'=>'comment edited'
                ]);
            } else {
                return response()->json([
                    'data'=> $comments,
                    'status'=>400,
                    'message'=>'edit failed'
                ]);
            }
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'doesnt exist'
            ]);
        }
    }

    public function deleteCommentBlog(Request $request) {
        $comment = CommentBlogAddress::find($request->comment_blog_id);
        if($comment){
            if($comment->delete()){
                $comments = CommentBlogAddress::where('blog_address_id', $request->blog_id)->get();
                foreach($comments as $cmt){
                    $commenter = User::where('id', $comment->id_user)->first();
                    $cmt->nickname=$commenter->nickname;
                    $cmt->avatar=$commenter->avatar;
                }
                return response()->json([
                    'data'=> $comments,
                    'status'=>200,
                    'message'=>'deleted'
                ]);
            } else {
                $comments = CommentBlogAddress::where('blog_address_id', $request->blog_id)->get();
                foreach($comments as $cmt){
                    $commenter = User::where('id', $comment->id_user)->first();
                    $cmt->nickname=$commenter->nickname;
                    $cmt->avatar=$commenter->avatar;
                }
                return response()->json([
                    'data'=> $comments,
                    'status'=>400,
                    'message'=>'cant delete'
                ]);
            }
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'doesnt exist'
            ]);
        }
    }
}
