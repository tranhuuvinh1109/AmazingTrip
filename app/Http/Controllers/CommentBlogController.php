<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentBlog;
use App\Models\User;

class CommentBlogController extends Controller
{
    //
    public function getAllCommentBlog ($blog_id){
        $comments = CommentBlog::where('blog_id', $blog_id)->get();
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

    public function createCommentBlog(Request $request){
        $comment = new CommentBlog();
        $comment->blog_id=$request->blog_id;
        $comment->id_user=$request->id_user;
        $comment->comment_blog_content= $request->comment_blog_content;

        if($comment->save()){
            $comments = CommentBlog::where('blog_id', $request->blog_id)->get();
            foreach($comments as $comment){
                $commenter = User::where('id', $comment->id_user)->first();
                $comment->nickname=$commenter->nickname;
                $comment->avatar=$commenter->avatar;
            }
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
        $comment = CommentBlog::find($request->comment_blog_id);
        if($comment){
            $comments = CommentBlog::where('blog_id', $request->blog_id)->get();
            $comment->comment_blog_content = $request->comment_blog_content;
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
        $comment = CommentBlog::find($request->comment_blog_id);
        if($comment){
            if($comment->delete()){
                $comments = CommentBlog::where('blog_id', $request->blog_id)->get();
                foreach($comments as $comment){
                    $commenter = User::where('id', $comment->id_user)->first();
                    $comment->nickname=$commenter->nickname;
                    $comment->avatar=$commenter->avatar;
                }
                return response()->json([
                    'data'=> $comments,
                    'status'=>200,
                    'message'=>'deleted'
                ]);
            } else {
                $comments = CommentBlog::where('blog_address_id', $request->blog_id)->get();
                foreach($comments as $comment){
                    $commenter = User::where('id', $comment->id_user)->first();
                    $comment->nickname=$commenter->nickname;
                    $comment->avatar=$commenter->avatar;
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
