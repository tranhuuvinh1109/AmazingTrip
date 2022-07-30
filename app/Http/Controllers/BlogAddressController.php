<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogAddress;
use App\Models\CommentBlogAddress;
use App\Models\ReactionBlogAddress;
use App\Models\User;

class BlogAddressController extends Controller

{
    public function getBlog($address_id)
    {
        $blog = BlogAddress::where('address_id', $address_id)->get();
        foreach($blog as $i){
            $user = User::where('id', $i->id_user)->first();
            $i->nickname=$user->nickname;
            $i->avatar=$user->avatar;
            $i->commentCount = CommentBlogAddress::where('blog_address_id', $i->blog_address_id)->count();
            $i->likeCount = ReactionBlogAddress::where('blog_address_id', $i->blog_address_id)->where('reaction', 1)->count();
            $i->dislikeCount=ReactionBlogAddress::where('blog_address_id', $i->blog_address_id)->where('reaction', 0)->count();
        }
            return response()->json([
                'data' => $blog,
                'status' => 200,
                'message' => 'Get blog successfully'
            ]);
    }
    public function postBlog(Request $req)
    {
        if($req){
            $blo =  new BlogAddress();
            $blo->id_user = $req->input('id_user');
            $blo->address_id = $req->input('address_id');
            $blo->blog_address_vote = $req->input('blog_address_vote');
            $blo->blog_address_image = $req->input('blog_address_image');
            $blo->blog_address_content = $req->input('blog_address_content');


            if($blo->save()){
                return response()->json([
                    'data' => [],
                    'status' => 200,
                    'message' => 'Post blog address successfully'
                ]);
            }else{
                return response()->json([
                    'data' => $blo,
                    'status' => 400,
                    'message' => 'Post blog address fail'
                ]);
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Post data fail'
            ]);
        }
    }
    public function editBlog(Request $req , $id)
    {
        $item = BlogAddress::find($id);
        if($req){
            $item->id_user = $req->input('id_user');
            $item->address_id = $req->input('address_id');
            $item->blog_address_title = $req->input('blog_address_title');
            $item->blog_address_image = $req->input('blog_address_image');
            $item->blog_address_content = $req->input('blog_address_content');
            if($item->save()){
                return response()->json([
                    'data' => $item,
                    'status' => 200,
                    'message' => 'Edit blog address successfully'
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Edit blog address fail'
                ]);
            }
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Post data fail'
            ]);
        }

    }
    public function deleteBlog($id)
    {
        if(BlogAddress::find($id)){
            if(BlogAddress::find($id)->delete()){
                $blog = BlogAddress::all();
                return response()->json([
                    'data' => $blog,
                    'status' => 200,
                    'message' => 'Delete blog address successfully'
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Delete blog address fail'
                ]);
            }
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Delete blog address fail'
            ]);
        }
    }
}
