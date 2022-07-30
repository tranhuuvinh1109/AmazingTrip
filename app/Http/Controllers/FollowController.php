<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Follow;

class FollowController extends Controller
{
    public function getFollow()
    {
        $follow = Follow::all();
        return response()->json([
            'data' =>  $follow,
            'status' => 200,
            'message' => 'Get follow successfully'
        ]);
    }
    public function postFollow(Request $req)
    {
        $follow = Follow::query()
            ->where('follow.follower', $req->follower)
            ->where('follow.being_follower', $req->being_follower)
            ->orderBy('follow.created_at', 'desc')
            ->first();
        if ($follow) {
            $follow->follow_status = $req->follow_status;
            $follow->save();
            $follow2 = Follow::query()
                ->join('user_travel', 'follow.being_follower', '=', 'user_travel.id')
                ->select('user_travel.id',
                    'user_travel.nickname',
                    'user_travel.avatar',
                    'follow.follow_status'
                )
                ->where('follow.follower', $req->follower)
                ->where('follow.being_follower', $req->being_follower)
                ->orderBy('follow.created_at', 'desc')
                ->first();
            return response()->json([
                'data' => $follow2,
                'status' => 200,
                'message' => 'Follow successfully'
            ]);
        } else {
            $follow = new Follow();
            $follow->follower = $req->input('follower');
            $follow->being_follower = $req->input('being_follower');
            $follow->follow_status = $req->input('follow_status');
            if ($follow->save()) {
                $follow = Follow::query()
                    ->join('user_travel', 'follow.being_follower', '=', 'user_travel.id')
                    ->select('user_travel.id',
                        'user_travel.nickname',
                        'user_travel.avatar',
                        'follow.follow_status'
                    )
                    ->where('follow.follower', $req->follower)
                    ->where('follow.being_follower', $req->being_follower)
                    ->orderBy('follow.created_at', 'desc')
                    ->first();
                return response()->json([
                    'data' => $follow,
                    'status' => 200,
                    'message' => 'Post follow successfully'
                ]);
            } else {
                return response()->json([
                    'data' => $follow,
                    'status' => 400,
                    'message' => 'Post follow fail'
                ]);
            }
        }
    }


    public function deleteFollow($id)
    {
        if (Follow::find($id)) {
            if (Follow::find($id)->delete()) {
                $follow = Follow::all();
                return response()->json([
                    'data' => $follow,
                    'status' => 200,
                    'message' => 'Delete follow successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Delete follow false'
                ]);
            }
        }
    }
}
