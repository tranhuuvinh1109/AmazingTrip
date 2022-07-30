<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\GroupMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function getGroup($address_id)
    {
        $group= Group::query()
            ->where('address_id', $address_id)
            ->get();
        return response()->json([
            'data'=>$group,
            'status'=>200,
            'message'=>'Get group successfully'
        ]);
    }
    public function NumberofGroups()
    {
        $group= Group::all();
        return $group->count(); 
    }

    public function showGroup($id)
    {
        $group= DB::table('Group')
            ->join('User_travel', 'Group.group_admin', '=', 'User_travel.id')
            ->join('Address', 'Group.address_id', '=', 'Address.address_id')
            ->select('Group.*',
                'User_travel.nickname',
                'User_travel.avatar',
                'Address.address_map',
            )
            ->where('Group.group_id', $id)
            ->first();

        $group_member = DB::table('Group_members')
            ->select(DB::raw('count(id_user) as number_member'))
            ->where('group_id', '=', $group->group_id)
            ->groupBy('group_id')
            ->first();

        if($group_member)
            $group->number_member = $group_member->number_member;
        else
            $group->number_member = 0;

        $members = DB::table('Group_members')
            ->join('User_travel', 'Group_members.id_user', '=', 'User_travel.id')
            ->select('User_travel.id',
                'User_travel.nickname',
                'User_travel.avatar',
            )
            ->where('group_id', '=', $group->group_id)
            ->get();

        if($group) {
            return response()->json([
                'data' => $group,
                'members' => $members,
                'status' => 200,
                'message' => 'Get group successfully'
            ]);
        } else {
            return response()->json([
                'data' => $group,
                'status' => 400,
                'message' => 'Get group false'
            ]);
        }
    }

    public function joinGroup(Request $request)
    {
        $group_member= new GroupMember();
        $group_member->group_id=$request->input('group_id');
        $group_member->id_user=$request->input('id_user');

        if($group_member->save()){
            $group_member = GroupMember::query()
                ->where('group_id', $group_member->group_id)
                ->where('id_user', $group_member->id_user)
                ->orderBy('created_at', 'desc')
                ->first();
            return response()->json([
                'data'=>$group_member,
                'status'=>200,
                'message'=>'success'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'false'

            ]);
        }
    }

    public function outGroup($group_id, $id_user)
    {
        $group_member = GroupMember::query()
            ->where('group_id', $group_id)
            ->where('id_user', $id_user)
            ->orderBy('created_at', 'desc')
            ->first();
        if($group_member->delete()){
            return response()->json([
                'data'=>[],
                'status'=>200,
                'message'=>'success'
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'false'

            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function postGroup(Request $request)
    {
         if($request){
            $group= new Group();
            $group->group_name=$request->input('group_name');
            $group->group_image=$request->input('group_image');
            $group->address_id=$request->input('address_id');
            $group->group_admin= $request->input('group_admin');

            if($group->save()){
                $data = Group::query()
                    ->select('group_id')
                    ->where('address_id', '=', $group->address_id)
                    ->where('group_admin', '=', $group->group_admin)
                    ->orderBy('created_at', 'desc')
                    ->first();
                $member = new GroupMember();
                $member->group_id = $data->group_id;
                $member->id_user = $group->group_admin;
                $member->save();
                return response()->json([
                    'data'=>$group,
                    'status'=>200,
                    'message'=>'success'
                ]);
            }else{
                return response()->json([
                    'status'=>400,
                    'message'=>'false'

                ]);
            }
         }else{
            return response()->json([
                'status' => 400,
                'message' => 'Post group fail'
            ]);
         }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editGroup(Request $request,$id)
    {
        $group= Group::find($id);
        if($request){
            $group->group_name=$request->input('group_name');
            $group->group_image=$request->input('group_image');
            //$group->address_id=$request->input('address_id');
           // $group->group_admin= $request->input('group_admin');
            $group->group_member=$request->input('group_member');
            if($group->save()){

                return response()->json([
                   'data'=>$group,
                   'status'=>200,
                   'message'=>'Update group successfullly'
                ]);
            }else{
                return response()->json([
                    'status'=>400,
                    'message'=>'Update group false'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */

    public function destroyGroup($id){
         if(Group::find($id)->delete()){
            $group= Group::all();
            return response()->jison([
                'data'=>$group,
                'status'=>200,
                'message'=>'Delete group successfull'
                ]);

         }else{
            return response()->json([
                'status'=>400,
                'message'=>'Delete group false'
                ]);

         }

    }

    public function GroupsByDate(){
        $date1 = date('Y-m-d', strtotime('-6 days'));
        $count1 = Group::whereDate('created_at', $date1)->count();
        $date2 = date('Y-m-d', strtotime('-5 days'));
        $count2 = Group::whereDate('created_at', $date2)->count();
        $date3 = date('Y-m-d', strtotime('-4 days'));
        $count3 = Group::whereDate('created_at', $date3)->count();
        $date4 = date('Y-m-d', strtotime('-3 days'));
        $count4 = Group::whereDate('created_at', $date4)->count();
        $date5 = date('Y-m-d', strtotime('-2 days'));
        $count5 = Group::whereDate('created_at', $date5)->count();
        $date6 = date('Y-m-d', strtotime('-1 days'));
        $count6 = Group::whereDate('created_at', $date6)->count();
        $date7 = date('Y-m-d', strtotime('-0 days'));
        $count7 = Group::whereDate('created_at', $date7)->count();
       

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
