<?php

use App\Http\Controllers\BlogAddressController;
use App\Http\Controllers\BlogAddressReactionController;
use App\Http\Controllers\CommentBlogAddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentBlogController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\GroupController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\BlogReactionController;
use App\Http\Controllers\FormRegisterController;
use App\Http\Controllers\LoginControler;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//login && register
Route::post('/login',[LoginControler::class,'PostLogin']);
Route::post('/register',[RegisterController::class,'PostRegister']);
Route::get('/users',[RegisterController::class,'getUsers']);



//Users
Route::get('/profile/{id}',[UserController::class,'getProfile']);
Route::get('/numberofusers',[UserController::class,'getNumberofUsers']);
Route::get('/numberofhosts',[UserController::class,'getNumberofHosts']);
Route::get('/infoofusers',[UserController::class,'getInfomationOfUsers']);
Route::get('/infoofhosts',[UserController::class,'getInfomationOfHosts']);
Route::delete('/delete/{id}',[UserController::class,'deleteUser']);
Route::get('/usersbydate',[UserController::class,'getUsersByDate']);
Route::get('/hostsbydate',[UserController::class,'getHostsByDate']);

Route::get('/getUser/{phone}',[GetUserController::class,'GetUser']);

Route::get('/profile/{user_id}/{current_user_id}',[UserController::class,'getProfile']);
Route::get('/user/{user_id}',[UserController::class,'getUserData']);

Route::get('/search={search}',[SearchController::class, 'Search']);


Route::get('/address',[AddressController::class,'getAddress']);
//Addresses
Route::get('/addresses',[AddressController::class,'getAddress']);
Route::get('/numberofaddresses',[AddressController::class,'getNumberofAddress']);
Route::get('/addressesbydate',[AddressController::class,'AddressesByDate']);
Route::post('/address',[AddressController::class,'postAddress']);
Route::get('/address/{address_id}/{id_user}',[AddressController::class,'getEachAddress']);
Route::post('/address/{id}',[AddressController::class,'editAddress']);
Route::delete('/address/{id}',[AddressController::class,'deleteAddress']);

Route::get('/address_by_host/{id}/{user_id}',[AddressController::class,'getAddressByHost']);
Route::get('/addressHost/{user_id}',[AddressController::class,'getAddressHost']);
Route::get('/listaddressbybookmark',[AddressController::class,'ListAddressByBookmark']);   // lấy địa điểm theo lượt theo dõi
Route::get('/listaddressbydiscount',[AddressController::class,'ListAddressByDiscount']);   // lấy địa điểm theo khuyến mãi
Route::get('/listaddressbookmarked/{id_user}',[AddressController::class,'ListAddressBookmarked']); // lấy danh sách địa điểm đã bookmark theo thời gian theo id_user

// Blog Address
Route::get('/blogAddress/{address_id}',[BlogAddressController::class,'getBlog']);
Route::get('/address_by_host/{id}',[AddressController::class,'getAddressByHost']);
Route::get('/blogaddresses',[BlogAddressController::class,'getAllBlogAddress']);
Route::get('/blog/{id}',[BlogController::class,'getBlog']);
Route::post('/blogAddress',[BlogAddressController::class,'postBlog']);
Route::delete('/blogaddress/{id}',[BlogAddressController::class,'deleteBlog']);

//Blog
Route::get('/blogs',[BlogController::class,'getBlog']);
Route::post('/blog',[BlogController::class,'postBlog']);
Route::patch('/blog/{id}',[BlogController::class,'editBlog']);
Route::delete('/blog/{id}',[BlogController::class,'deleteBlog']);
Route::get('/allblogs',[BlogController::class,'getAllBlogs']);
Route::get('/getinfoallblogs',[BlogController::class,'getInfoAllBlogs']);
Route::get('/blogsbydate',[BlogController::class,'BlogsByDate']);

//Comment
Route::post('/createComment',[CommentBlogController::class, 'createCommentBlog']);
Route::get('/comments/{blog_id}',[CommentBlogController::class, 'getAllCommentBlog']);
Route::patch('/editComment',[CommentBlogController::class, 'editCommentBlog']);
Route::delete('/deleteComment/{comment_blog_id}',[CommentBlogController::class, 'deleteCommentBlog']);
Route::post('/reactBlog',[BlogReactionController::class, 'reactionUpdate']);
Route::get('/reactCheck/{blog_id}/{id_user}',[BlogReactionController::class, 'reactionCheck']);
Route::delete('/unReaction/{blog_id}/{id_user}',[BlogReactionController::class, 'unReaction']);

//Bookmark
Route::get('/bookmark/{id_user}',[BookmarkController::class,'getBookmark']);
Route::get('/userBookmark/{address_id}',[BookmarkController::class,'getUserBookmark']);
Route::get('/bookmark/{address_id}/{id_user}',[BookmarkController::class,'checkBookmark']);
Route::get('/groupAddress/{address_id}',[GroupController::class,'getGroup']);
Route::post('/bookmark',[BookmarkController::class,'postBookmark']);
Route::delete('/bookmark/{id}',[BookmarkController::class,'deleteBookmark']);

//Groups
Route::post('/CreateGroupForm',[CreateGroupFormController::class,'CreateGroup']);

Route::get('/groups',[GroupController::class,'getGroup']);
Route::get('/numberofgroups',[GroupController::class,'NumberofGroups']);
Route::get('/groupsbydate',[GroupController::class,'GroupsByDate']);
Route::get('/group/{id}',[GroupController::class,'showGroup']) ; // show detail 1 group
Route::post('/joinGroup',[GroupController::class,'joinGroup']);
Route::delete('/outGroup/{group_id}/{id_user}',[GroupController::class,'outGroup']);
Route::post('/group',[GroupController::class,'postGroup']);
Route::patch('/group/{id}',[GroupController::class,'editGroup']);
Route::delete('/group/{id}',[GroupController::class,'deleteGroup']);

//Follow
Route::get('/follow',[FollowController::class,'getFollow']);
Route::post('/follow',[FollowController::class,'postFollow']);
Route::delete('/follow/{id}',[FollowController::class,'deleteFollow']);

//Discount
Route::get('/discount',[DiscountController::class,'getDiscount']);
Route::post('/discount',[DiscountController::class,'postDiscount']);
Route::patch('/discount/{id}',[DiscountController::class,'editDiscount']);
Route::delete('/discount/{id}',[DiscountController::class,'deleteDiscount']);
Route::get('/discount/address={address_id}',[DiscountController::class,'getFormDiscount']);

//comment
Route::post('/createCommentBlog/{blog_id}',[CommentBlogAddressController::class, 'createCommentBlog']);
Route::get('/commentsBlog/{blog_id}',[CommentBlogAddressController::class, 'getAllCommentBlog']);
Route::patch('/editCommentBlog',[CommentBlogAddressController::class, 'editCommentBlog']);
Route::delete('/deleteCommentBlog/{comment_blog_id}',[CommentBlogAddressController::class, 'deleteCommentBlog']);
Route::post('/reactAddressBlog',[BlogAddressReactionController::class, 'reactionUpdate']);
Route::get('/reactAddressCheck/{blog_address_id}/{id_user}',[BlogAddressReactionController::class, 'reactionCheck']);
Route::delete('/unReactionAddress/{blog_address_id}/{id_user}',[BlogAddressReactionController::class, 'unReaction']);

Route::get('/getRegisters/{address_id}',[FormRegisterController::class, 'getRegisterListForAddress']);
Route::post('/createForm',[FormRegisterController::class, 'postFormRegister']);
Route::patch('/editForm/{id}',[FormRegisterController::class, 'editFormRegister']);
Route::delete('/deleteForm/{discount_id}/{id_user}',[FormRegisterController::class, 'deleteFormRegister']);
//Route::get('/getUser/{phone}',[GetUserController::class,'GetUser']);
//Commment
Route::post('/createCommentBlog',[CommentBlogAddressController::class, 'createCommentBlog']);
Route::get('/commentsBlog/{blog_id}',[CommentBlogAddressController::class, 'getAllCommentBlog']);
Route::patch('/editCommentBlog',[CommentBlogAddressController::class, 'editCommentBlog']);
Route::delete('/deleteCommentBlog/{comment_blog_id}',[CommentBlogAddressController::class, 'deleteCommentBlog']);

//Reaction
Route::post('/reactBlog',[BlogReactionController::class, 'reactionUpdate']);


Route::get('/allInfoAddresses/{id_user}',[AddressController::class, 'getAllInfoAddress']);
