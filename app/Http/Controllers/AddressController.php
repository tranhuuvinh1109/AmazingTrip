<?php

namespace App\Http\Controllers;

use App\Models\CommentBlogAddress;
use App\Models\Discount;
use App\Models\Group;
use App\Models\ReactionBlogAddress;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\BlogAddress;
use App\Models\FormRegister;
use App\Models\User;
use App\Models\Bookmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddressController extends Controller
{
    public function getAddress()
    {
        $address = Address::all();
        foreach ($address as $i) {
            $user = User::where('id', $i->id_host)->first();
            $i->nickname = $user->nickname;
            $i->avatar = $user->avatar;
            $i->blogCount = BlogAddress::where('address_id', $i->address_id)->first();
            // $i->formCount=FormRegister::where('address_id', $i->address_id)->first();
        }
        return response()->json([
            'data' => $address,
            'status' => 200,
            'message' => 'Get address successfully'
        ]);
    }
    public function getNumberofAddress()
    {
        $address = Address::all();
        return $address->count();
    }
    public function postAddress(Request $req)
    {
        if ($req) {
            $add =  new Address();
            $add->id_host = $req->input('id_host');
            $add->address_name = $req->input('address_name');
            $add->address_description = $req->input('address_description');
            $add->address_image = $req->input('address_image');
            $add->address_map = $req->input('address_map');
            if ($add->save()) {
                $address = Address::where('id_host', $req->id_host)->orderBy('created_at', 'desc')->first();
                return response()->json([
                    'data' => $address,
                    'status' => 200,
                    'message' => 'Post address successfully'
                ]);
            } else {
                return response()->json([
                    'data' => $add,
                    'status' => 400,
                    'message' => 'Post address fail'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Post address fail'
            ]);
        }
    }


    public function getEachAddress($address_id, $id_user)
    {
        // Get Address Data
        $address = Address::query()
            ->join('user_travel', 'address.id_host', '=', 'user_travel.id')
            ->where('address_id', '=', $address_id)
            ->select(
                'address.address_id',
                'address.address_name',
                'address.address_description',
                'address.address_image',
                'address.address_map',
                'user_travel.id',
                'user_travel.nickname',
                'user_travel.avatar'
            )
            ->first();
        if ($address) {
            // Get group address data
            $group = Group::query()
                ->select('group_id', 'group_name')
                ->where('address_id', '=', $address->address_id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Get discount data
            $discount = Discount::query()
                ->select(
                    'discount.discount_id',
                    'discount.time_start',
                    'discount.time_finish',
                    'discount.discount_rate',
                    'discount.discount_quantity'
                )
                ->where('discount.address_id', '=', $address->address_id)
                ->first();
            if ($discount) {
                $registed = FormRegister::query()->where('discount_id', $discount->discount_id)->sum('quantity_registed');
                $discount->quantity_registed = $registed;
                $friendList = FormRegister::query()
                    ->join('user_travel', 'form_registed.id_user', '=', 'user_travel.id')
                    ->select(
                        'user_travel.id as id_user',
                        'user_travel.nickname',
                        'user_travel.avatar'
                    )
                    ->where('discount_id', $discount->discount_id)
                    ->get();
            } else {
                $friendList = [];
            }
            $blog = BlogAddress::query()
                ->join('user_travel', 'blog_address.id_user', '=', 'user_travel.id')
                ->select(
                    'blog_address.blog_address_id',
                    'blog_address.blog_address_vote',
                    'blog_address.blog_address_image',
                    'blog_address.blog_address_content',
                    'blog_address.created_at',
                    'user_travel.id',
                    'user_travel.avatar',
                    'user_travel.nickname'
                )
                ->where('address_id', $address->address_id)
                ->orderBy('created_at', 'desc')
                ->get();
            $voteCount = 0;
            $voteTotal = 0;
            foreach ($blog as $i) {
                if ($i->blog_address_vote) {
                    $voteCount += 1;
                    $voteTotal += $i->blog_address_vote;
                }
                $i->commentCount = CommentBlogAddress::query()->where('blog_address_id', $i->blog_address_id)->count();
                $i->likeCount = ReactionBlogAddress::query()->where('blog_address_id', $i->blog_address_id)->where('reaction', 1)->count();
                $i->dislikeCount = ReactionBlogAddress::query()->where('blog_address_id', $i->blog_address_id)->where('reaction', 0)->count();
                $react = ReactionBlogAddress::query()->where('blog_address_id', $i->blog_address_id)->where('id_user', $id_user)->first();
                if ($react) {
                    $i->reactStatus = $react->reaction;
                } else {
                    $i->reactStatus = null;
                }
            }
            if ($voteCount != 0) {
                $address->vote = $voteTotal / $voteCount;
            }
            $bookmark = Bookmark::query()
                ->where('address_id', '=', $address_id)
                ->where('id_user', '=', $id_user)
                ->where('status', '=','1')
                ->first();
            return response()->json([
                'address' => $address,
                'group' => $group,
                'blog' => $blog,
                'discount' => $discount,
                'friendList' => $friendList,
                'bookmark' => $bookmark,
                'status' => 200,
                'message' => 'Founded address successfully'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Address not found'
            ]);
        }
    }


    public function editAddress(Request $req, $id)
    {
        $item = Address::find($id);
        if ($req) {
            $item->id_host = $req->input('id_host');
            $item->address_name = $req->input('address_name');
            $item->address_description = $req->input('address_description');
            $item->address_image = $req->input('address_image');
            $item->address_map = $req->input('address_map');
            if ($item->save()) {
                return response()->json([
                    'data' => $item,
                    'status' => 200,
                    'message' => 'Edit address successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Edit address fail'
                ]);
            }
        }
    }
    public function deleteAddress($req)
    {
        if ($req) {
            if (Address::find($req->id)->delete()) {
                $address = Address::where('id_host', $req->id_host)->get();
                foreach ($address as $i) {
                    $user = User::where('id', $i->id_host)->first();
                    $i->nickname = $user->nickname;
                    $i->avatar = $user->avatar;
                    $i->blogCount = BlogAddress::where('address_id', $i->address_id)->first();
                    $i->formCount = FormRegister::where('address_id', $i->address_id)->first();
                }
                $address = Address::all();
                return response()->json([
                    'data' => $address,
                    'status' => 200,
                    'message' => 'Delete address successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Delete address fail'
                ]);
            }
        }
    }

    public function getAddressHost($id_host)
    {
        $address = Address::where('id_host', $id_host)->get();
        return response()->json([
            'data' => $address,
            'status' => 200,
            'message' => 'Get address successfully'
        ]);
    }

    public function getAddressByHost($address_id, $user_id)
    {
        $result = Address::where('address_id', $address_id)->where('id_host', $user_id)->first();
        $user = User::where('id', $result->id_host)->first();
        $result->nickname = $user->nickname;
        $result->avatar = $user->avatar;
        $discount = Discount::where('address_id', $address_id)->orderBy('created_at', 'desc')->first();
        if ($discount) {
            $registed = FormRegister::where('discount_id', $discount->discount_id)->sum('quantity_registed');
            $discount->quantity_registed = $registed;
        }
        //$result->blogCount=BlogAddress::where('address_id', $result->address_id)->first();
        //$result->formCount=FormRegister::where('address_id', $result->address_id)->first();
        if ($result) {
            return response()->json([
                'data' => $result,
                'discount' => $discount,
                'status' => 200,
                'message' => 'Get address by id host'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Address not found'
            ]);
        }
    }




    //tìm danh sách address theo lượt theo dõi nhiều nhất
    public function ListAddressByBookmark()
    {
        $address = Address::all();
        if ($address) {
            $address_count = Address::all()->count();
            foreach ($address as $add) {
                $add->count = Bookmark::where('address_id', $add->address_id)->count();
            }
            for ($i = 0; $i < $address_count; $i++) {
                $max = $address[0];
                for ($j = $i + 1; $j < $address_count; $j++) {
                    if ($address[$j]->count > $address[$i]->count) {
                        $max = $address[$i];
                        $address[$i] = $address[$j];
                        $address[$j] = $max;
                    }
                }
            }
            return response()->json([
                'data' => $address,
                'status' => 200,
                'message' => 'get address succesfully'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'have no address'
            ]);
        }
    }



    //tìm danh sách address có theo  khuyến mãi
    public function ListAddressByDiscount()
    {
        $address = DB::table('address')
            ->join('discount', 'address.address_id', '=', 'discount.address_id')
            ->select('address.*', 'discount.discount_rate')
            ->orderBy('discount.discount_rate', 'desc')->get();
        foreach ($address as $add) {
            $add->count = Bookmark::where('address_id', $add->address_id)->count();
        }
        if ($address) {
            return response()->json([
                'data' => $address,
                'status' => 200,
                'message' => 'get address succesfully'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Have no address'
            ]);
        }
    }



    // danh sách tất cả address đã theo dõi ( sắp xếp theo thời gian)
    public function ListAddressBookmarked($id_user)
    {
        $address = DB::table('address')
            ->join('bookmark', 'address.address_id', '=', 'bookmark.address_id')
            ->select('address.*')
            ->where('bookmark.id_user', '=', $id_user)
            ->where('bookmark.status', '=', 1)
            ->orderBy('created_at', 'desc')->get();
        $count = Bookmark::where('id_user', $id_user)->count();
        if ($address) {
            return response()->json([
                'data' => $address,
                'count' => $count,
                'status' => 200,
                'message' => 'get address succesfully'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Have no address'
            ]);
        }
    }

    public function AddressesByDate()
    {
        $date1 = date('Y-m-d', strtotime('-6 days'));
        $count1 = Address::whereDate('created_at', $date1)->count();
        $date2 = date('Y-m-d', strtotime('-5 days'));
        $count2 = Address::whereDate('created_at', $date2)->count();
        $date3 = date('Y-m-d', strtotime('-4 days'));
        $count3 = Address::whereDate('created_at', $date3)->count();
        $date4 = date('Y-m-d', strtotime('-3 days'));
        $count4 = Address::whereDate('created_at', $date4)->count();
        $date5 = date('Y-m-d', strtotime('-2 days'));
        $count5 = Address::whereDate('created_at', $date5)->count();
        $date6 = date('Y-m-d', strtotime('-1 days'));
        $count6 = Address::whereDate('created_at', $date6)->count();
        $date7 = date('Y-m-d', strtotime('-0 days'));
        $count7 = Address::whereDate('created_at', $date7)->count();


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
