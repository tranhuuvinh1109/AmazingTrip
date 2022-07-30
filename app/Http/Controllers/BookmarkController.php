<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    public function getBookmark($id_user)
    {
        $bookmark = Bookmark::select('address_id')->where('id_user', $id_user)->where('status', '=', '1')->get();
        foreach($bookmark as $each)
        {
            $address = Address::where('address_id', $each->address_id)->first();
            $each->address_name = $address->address_name;
            $each->count = Bookmark::where('address_id',$each->address_id)->count();
            $each->address_image = $address->address_image;

        }
        return response()->json([
            'data' =>  $bookmark,
            'status' => 200,
            'message' => 'Get address successfully'
        ]);
    }

    public function getUserBookmark($address_id)
    {
        $bookmark = Bookmark::query()
            ->join('address', 'bookmark.address_id', '=', 'address.address_id')
            ->select('bookmark.id_user',
                'address.address_id',
                'address.address_name',
            )
            ->where('bookmark.address_id', '=', $address_id)
            ->get();
        return response()->json([
            'data' =>  $bookmark,
            'status' => 200,
            'message' => 'Get address successfully'
        ]);
    }

    public function checkBookmark($address_id, $id_user)
    {
        $bookmark = Bookmark::where('address_id', $address_id)->where('id_user', $id_user)->first();
        if($bookmark)
        {
            return response()->json([
                'data' =>  $bookmark,
                'status' => 200,
                'message' => 'Get address successfully'
            ]);
        } else {
            return response()->json([
                'data' =>  $bookmark,
                'status' => 400,
                'message' => 'Get address failed'
            ]);
        }
    }

    public function postBookmark(Request $req)
    {
        if($req){
            $bookmark = Bookmark::where('address_id', $req->address_id)->where('id_user', $req->id_user)->first();
            if($bookmark)
            {
                $bookmark->status = $req->status;
                $bookmark->save();
                return response()->json([
                    'data' => $bookmark,
                    'status' => 200,
                    'message' => 'Update Bookmark successfully'
                ]);
            } else {
                $book = new Bookmark();
                $book->address_id = $req->input('address_id');
                $book->id_user = $req->input('id_user');
                $book->status = $req->input('status');
                if($book->save()){
                    return response()->json([
                        'data' => $book, //1 for +, 0 for -
                        'status' => 200,
                        'message' => 'Bookmark successfully'
                    ]);
                }else{
                    return response()->json([
                        'data' => $book,
                        'status' => 400,
                        'message' => 'Bookmark failed'
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'doesnt exist'
            ]);
        }
    }

    public function deleteBookmark(Request $req)
    {
        $bookmark = Bookmark::where('id_user', $req->id_user)->where('address_id', $req->address_id)->first();
        if($bookmark){
            if($bookmark->delete()){
                $data = Bookmark::where('id_user', $req->id_user)->get();
                return response()->json([
                    'data' => $data,
                    'status' => 200,
                    'message' => 'Delete bookmark successfully'
                ]);
            }else{
                return response()->json([
                    'data'=> Bookmark::where('id_user', $req->id_user)->get(),
                    'status' => 400,
                    'message' => 'Delete bookmark fail'
                ]);
            }
        } else {
            return response()->json([
                'data'=>Bookmark::where('id_user', $req->id_user)->get(),
                'status' => 404,
                'message' => 'doesnt exist'
            ]);
        }
    }
}
