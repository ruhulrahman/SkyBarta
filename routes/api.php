<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Broadcast::routes();

Route::apiResources([
    'auth' => 'API\AuthController',
    'user' => 'API\UserController',
    'gender' => 'API\GenderController',
    'relation' => 'API\RelationController',
    'religion' => 'API\ReligionController',
    'role' => 'API\RoleController',
    'userRole' => 'API\UserRoleController',
    'skill' => 'API\SkillController',
    'userSkill' => 'API\UserSkillController',
    'gender' => 'API\GenderController',
    'blood' => 'API\BloodController',
    'privacy' => 'API\PrivacyController',
    'comment' => 'API\CommentController',
    'degree' => 'API\DegreeController',
    'major' => 'API\MajorController',
    'image' => 'API\ImageController',
    'like' => 'API\LikeController',
    'friend' => 'API\FriendController',
    'follow' => 'API\FollowController',
    'permanentAddress' => 'API\PermanentAddressController',
    'presentAddress' => 'API\PresentAddressController',
    'post' => 'API\PostController',
    'profession' => 'API\ProfessionController',
    'profile' => 'API\ProfileController',
    'division' => 'API\DivisionController',
    'district' => 'API\DistrictController',
    'thana' => 'API\ThanaController',
    'location' => 'API\UserLocationController',
    'userEducation' => 'API\UserEducationContoller',
    'message' => 'API\MessageController',
    'video' => 'API\VideoChatController',
    //Job ------------------
    'company' => 'API\CompanyController',
    'job' => 'API\JobController',
    'jobapply' => 'API\JobApplyController',
    'siteinfo' => 'API\SiteInfoController',
]);

//JobController
Route::get('findJob', 'API\JobController@findJob');

//JobController
Route::post('register', 'API\AuthController@register');
Route::post('login', 'API\AuthController@login');

//JobController
Route::get('jobapplyCheck/{id}', 'API\JobApplyController@jobapplyCheck');
Route::get('jobapplicants/{id}', 'API\JobApplyController@jobapplicants');

//DivisionController
Route::get('districtByDivision/{id}', 'API\DivisionController@districtByDivision');

//ProfessionController
Route::get('get-user-by-profession/{id}', 'API\ProfessionController@getuserbyprofession');

//DivisionController
Route::get('thanaByDistrict/{id}', 'API\DistrictController@thanaByDistrict');

// PostController
Route::get('postByAuth', 'API\PostController@postByAuth');

// MessageController
Route::get('contacts', 'API\MessageController@contacts');
Route::get('conversation/{id}', 'API\MessageController@conversation');
Route::post('conversation/send', 'API\MessageController@send');
Route::post('conversation/sendMessage', 'API\MessageController@sendMessage');

// Route::post('commentadd', 'API\MessageController@commentadd');
// LikeController
Route::get('likeCreate/{post_id}', 'API\LikeController@likeCreate');
Route::get('likeCount/{post_id}', 'API\LikeController@likeCount');


//UserController
Route::get('rollingUser', 'API\UserController@rollingUser');
Route::get('userten', 'API\UserController@userten');
Route::get('user-auth-id', 'API\UserController@user_auth_id');
Route::get('timeline', 'API\UserController@timeline');
Route::get('userprofile/user/{slug}', 'API\UserController@profile');
Route::get('userTimeInfo', 'API\UserController@userTimeInfo');
Route::get('usersInfo/{slug}', 'API\UserController@usersInfo');
Route::get('userlocation/{slug}', 'API\UserLocationController@userLocation');
Route::get('usereducation/{slug}', 'API\UserEducationContoller@userEducation');
Route::get('userpost/{slug}', 'API\PostController@userPost');
Route::put('updateProfile', 'API\UserController@updateProfile');

//UserLocationController
Route::get('getUserlocation', 'API\UserLocationController@getUserlocation');
Route::put('updateUserLocation/{user_id}', 'API\UserLocationController@updateUserLocation');

//FriendController
Route::get('findFriend', 'API\FriendController@findFriend');
Route::get('friendRequest', 'API\FriendController@friendRequest');
Route::get('confirmRequest/{id}', 'API\FriendController@confirmRequest');
Route::get('friendList', 'API\FriendController@friendList');
Route::get('addFriend/{id}', 'API\FriendController@addFriend');

//Search Users
Route::get('findUser', 'API\UserController@search');
Route::get('findPeople', 'API\UserController@findPeople');
Route::get('people', 'API\UserController@people');
Route::get('findUserByprofession/{id}', 'API\ProfessionController@findUserByprofession');

//Post Controller
Route::get('getCommentCountByPost', 'API\PostController@getCommentCountByPost');
Route::get('getCommentByPost/{id}', 'API\PostController@getCommentByPost');
Route::get('getLikeCountByPost/{id}', 'API\PostController@getLikeCountByPost');
Route::get('getLikeByPost/{id}', 'API\PostController@getLikeByPost');

Route::get('findUserByBlood/{id}', 'API\BloodController@findUserByBlood');
Route::get('findContact', 'API\MessageController@findContact');


//Counting for Statistics ============================================
Route::get('newPost', 'API\PostController@newPost');
Route::get('totalPost', 'API\PostController@totalPost');

Route::get('newUser', 'API\UserController@newUser');
Route::get('totalUser', 'API\UserController@totalUser');

Route::get('newFemaleUser', 'API\UserController@newFemaleUser');
Route::get('newMaleUser', 'API\UserController@newMaleUser');

Route::get('totalFemaleUser', 'API\UserController@totalFemaleUser');
Route::get('totalMaleUser', 'API\UserController@totalMaleUser');

Route::get('newLike', 'API\LikeController@newLike');
Route::get('totalLike', 'API\LikeController@totalLike');

Route::get('newComment', 'API\CommentController@newComment');
Route::get('totalComment', 'API\CommentController@totalComment');

Route::get('newMessage', 'API\MessageController@newMessage');
Route::get('totalMessage', 'API\MessageController@totalMessage');

Route::get('followingCountInTimeline', 'API\FollowController@followingCountInTimeline');
Route::get('followerCountInTimeline', 'API\FollowController@followerCountInTimeline');
Route::get('followingCount/{id}', 'API\FollowController@followingCount');
Route::get('followerCount/{id}', 'API\FollowController@followerCount');
Route::get('followerCreate/{id}', 'API\FollowController@followerCreate');
Route::get('getFollower/{id}', 'API\FollowController@getFollower');
Route::get('authInfo/{id}', 'API\FollowController@authInfo');
Route::get('getFollowPost', 'API\FollowController@getFollowPost');
Route::get('getfollow', 'API\FollowController@getfollow');

