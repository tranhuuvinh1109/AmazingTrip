<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\BlogAddress;
use App\Models\Bookmark;
use App\Models\CommentBlogAddress;
use App\Models\Follow;
use App\Models\GroupMember;
use App\Models\ReactionBlogAddress;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getProfile($user_id, $current_user_id)
    {
        if ($user_id != 0) {
            $profile = User::query()
                ->select('user_travel.id',
                    'user_travel.nickname',
                    'user_travel.avatar',
                    'user_travel.birthday',
                    'user_travel.address',
                    'user_travel.created_at',
                )
                ->where('user_travel.id', '=', $user_id)
                ->first();
            $follow = Follow::query()
                ->select('follow_status',)
                ->where('follower', '=', $current_user_id)
                ->where('being_follower', '=', $user_id)
                ->where('follow_status', '=', '1')
                ->first();
            if($follow)
                $profile->follow_status = $follow->follow_status;
            else
                $profile->follow_status = null;
            $followCount = Follow::query()
                ->select( DB::raw('count(follower) as number_follow'))
                ->where('being_follower', '=', $user_id)
                ->where('follow_status', '=', '1')
                ->groupBy('being_follower')
                ->first();
            if($followCount)
                $profile->number_follow = $followCount->number_follow;
            else
                $profile->number_follow = 0;
            $blog = BlogAddress::query()
                ->join('address', 'blog_address.address_id', '=', 'address.address_id')
                ->join('user_travel', 'blog_address.id_user', '=', 'user_travel.id')
                ->select('blog_address.blog_address_id',
                    'blog_address.blog_address_vote',
                    'blog_address.blog_address_image',
                    'blog_address.blog_address_content',
                    'blog_address.created_at',
                    'address.address_name',
                    'address.address_id',
                    'user_travel.id',
                    'user_travel.avatar',
                    'user_travel.nickname'
                )
                ->where('blog_address.id_user', '=', $user_id)
                ->orderBy('blog_address.created_at', 'desc')
                ->get();
            foreach ($blog as $i) {
                $i->commentCount = CommentBlogAddress::query()->where('blog_address_id', $i->blog_address_id)->count();
                $i->likeCount = ReactionBlogAddress::query()->where('blog_address_id', $i->blog_address_id)->where('reaction', 1)->count();
                $i->dislikeCount = ReactionBlogAddress::query()->where('blog_address_id', $i->blog_address_id)->where('reaction', 0)->count();
                $react = ReactionBlogAddress::query()->where('blog_address_id', $i->blog_address_id)->where('id_user', $current_user_id)->first();
                if($react)
                {
                    $i->reactStatus = $react->reaction;
                } else {
                    $i->reactStatus = null;
                }
            }
            if ($profile) {
                return response()->json(
                    [
                        'status' => 200,
                        'data' => $profile,
                        'blog' => $blog
                    ]
                );
            } else {
                return response()->json(
                    [
                        'status' => 400,
                        'message' => 'Get profile fail'
                    ]
                );
            }
        }
    }


    public function getUserData($user_id)
    {
        if ($user_id != 0) {
            $bookmark = Bookmark::query()
                ->join('address', 'bookmark.address_id', '=', 'address.address_id')
                ->select('address.address_id', 'address.address_name', 'address.address_image')
                ->where('id_user', '=', $user_id)
                ->where('status', '=', '1')
                ->get();

            $follow = Follow::query()
                ->join('user_travel', 'follow.being_follower', '=', 'user_travel.id')
                ->select('user_travel.id', 'user_travel.nickname', 'user_travel.avatar')
                ->where('follower', '=', $user_id)
                ->where('follow_status', '=', '1')
                ->get();

            $group = GroupMember::query()
                ->join('group', 'group_members.group_id', '=', 'group.group_id')
                ->select('group.group_name', 'group_members.group_id')
                ->where('group_members.id_user', '=', $user_id)
                ->orderBy('group_members.created_at', 'desc')
                ->get();

            return response()->json(
                [
                    'bookmark' => $bookmark,
                    'follow' => $follow,
                    'group' => $group,
                    'status' => 200,
                    'message' => 'Get profile successfully'
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'Get profile fail'
                ]
            );
        }
    }
    public function getNumberofUsers(){
        $users = User::where('role', '2')->get();
        return  $users->count();
    }
    public function getNumberofHosts(){
        $users = User::where('role', '1')->get();
        return  $users->count();
    }

    public function getInfomationOfHosts(){
        $users = User::where('role', '1')->get();
        return  $users;
    }

    public function getInfomationOfUsers(){
        $users = User::where('role', '2')->get();
        return  $users;
    }

    public function deleteUser($id){
       if( User::find($id)->delete()){
        return 'Delete user successfully';
       }
       else {
        return 'Cannot delete this user';
       }
        
    }

    public function getUsersByDate(){
        $data = array();
        $date1 = date('Y-m-d', strtotime('-6 days'));
        $count1 = User::whereDate('created_at', $date1)->where('role', '2')->count();
        $date2 = date('Y-m-d', strtotime('-5 days'));
        $count2 = User::whereDate('created_at', $date2)->where('role', '2')->count();
        $date3 = date('Y-m-d', strtotime('-4 days'));
        $count3 = User::whereDate('created_at', $date3)->where('role', '2')->count();
        $date4 = date('Y-m-d', strtotime('-3 days'));
        $count4 = User::whereDate('created_at', $date4)->where('role', '2')->count();
        $date5 = date('Y-m-d', strtotime('-2 days'));
        $count5 = User::whereDate('created_at', $date5)->where('role', '2')->count();
        $date6 = date('Y-m-d', strtotime('-1 days'));
        $count6 = User::whereDate('created_at', $date6)->where('role', '2')->count();
        $date7 = date('Y-m-d', strtotime('-0 days'));
        $count7 = User::whereDate('created_at', $date7)->where('role', '2')->count();
       

        // $dateExact = substr($date, 0, 10);
        return response()->json([
            'date1' => $date1,
            'count1' => $count1,
            'date2' => $date2,
            'count2' => $count2,
            'date3' => $date3,
            'count3' => $count3,
            'date4' => $date4,
            'count4' => $count4,
            'date5' => $date5,
            'count5' => $count5,
            'date6' => $date6,
            'count6' => $count6,
            'date7' => $date7,
            'count7' => $count7,
        ]);


    }

    public function getHostsByDate(){
        $date1 = date('Y-m-d', strtotime('-6 days'));
        $count1 = User::whereDate('created_at', $date1)->where('role', '1')->count();
        $date2 = date('Y-m-d', strtotime('-5 days'));
        $count2 = User::whereDate('created_at', $date2)->where('role', '1')->count();
        $date3 = date('Y-m-d', strtotime('-4 days'));
        $count3 = User::whereDate('created_at', $date3)->where('role', '1')->count();
        $date4 = date('Y-m-d', strtotime('-3 days'));
        $count4 = User::whereDate('created_at', $date4)->where('role', '1')->count();
        $date5 = date('Y-m-d', strtotime('-2 days'));
        $count5 = User::whereDate('created_at', $date5)->where('role', '1')->count();
        $date6 = date('Y-m-d', strtotime('-1 days'));
        $count6 = User::whereDate('created_at', $date6)->where('role', '1')->count();
        $date7 = date('Y-m-d', strtotime('-0 days'));
        $count7 = User::whereDate('created_at', $date7)->where('role', '1')->count();
       

        // $dateExact = substr($date, 0, 10);
        return response()->json([
            'date1' => $date1,
            'count1' => $count1,
            'date2' => $date2,
            'count2' => $count2,
            'date3' => $date3,
            'count3' => $count3,
            'date4' => $date4,
            'count4' => $count4,
            'date5' => $date5,
            'count5' => $count5,
            'date6' => $date6,
            'count6' => $count6,
            'date7' => $date7,
            'count7' => $count7,
        ]);


    }

    


}
