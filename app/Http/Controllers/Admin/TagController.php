<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tag_Parents;
use App\Model\AgeRangeLevel;
use App\Model\Levels;
use App\Model\Questions;
use App\Model\TestResult;
use App\Model\ParentTestResult;
use App\Model\Countries;
use App\Model\AddRequest;
use App\Model\CountryWiseScore;
use App\Model\Category;
use App\Model\ParentCategory;
use App\Model\Parents;
use Validator;
use Session;
use Response;
use Auth;
use DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ChildPassword;
use App\Helpers\Helper;
use Notification;
use Share;
use App\Model\OverAllRange;
use Carbon\Carbon;
use Exception;

class TagController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | TagController
      |--------------------------------------------------------------------------
      |
      | Here we can make a controller for tagg child, add child
      | show child listing on the index page.
      |
     */

    /*
     * @created : January 27, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view index page of child.
     * @params  : None
     * @return  : None
     */

    public function index(Request $request) {
        try {
            $id = Auth::user()->id;
            $tagresult = Tag_Parents::where('parent_id', $id)->orderBy('id', 'DESC')->get()->toArray();

            if (!$tagresult) {
                return view('front_end.tagged');
            } else {
                $data = Tag_Parents::childlayout($tagresult);
                $childresult = $data['testresult'];
                if (!empty($data['cat_result'])) {
                    $cat_result = $data['cat_result'];
                }
                $user_counts = $data['user_counts'];
                $childrecord = $data['childrecord'];
                if (!empty($data['maxnchild'])) {
                    $maxnchild = $data['maxnchild'];
                }
                $nextresultid = $data['nextresultid'];
                return view('admin.parent.childview', compact('cat_result', 'nextresultid', 'maxnchild' . 'images'))->with(['childresult' => $childresult, 'user_counts' => $user_counts, 'childrecord' => $childrecord]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : January 27, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view index page of child.
     * @params  : None
     * @return  : None
     */

    public function childPage($curr_child_id = "", Request $request) {
        try {
            $user = Auth::user();
            if ($user->user_type == '2') {
                $tagresult = Tag_Parents::where('parent_id', $user->id)->where('request_mode', '1')->get()->toArray();
            } else if ($user->user_type == '3') {
                $tagresult = Tag_Parents::where('request_mode', '2')->where(function ($query) use ($user) {
                            $query->where('user_id', $user->id)
                                    ->orWhere('parent_id', $user->id);
                        })->get()->toArray();
            }
//            $current_user_data= user::find($curr_child_id);

            if (!$tagresult) {
                return view('front_end.tagged', compact('images'));
            } else {
                if ($user->user_type == '2') {
                    $child_id = array_column($tagresult, 'user_id');
                } else if ($user->user_type == '3') {
                    $child_id = array_unique(array_merge(array_column($tagresult, 'user_id'), array_column($tagresult, 'parent_id')));
                    if (in_array($user->id, $child_id)) {
                        $current_index = array_search($user->id, $child_id);
                        unset($child_id[$current_index]);
                    };
                    $child_id = array_values($child_id);
                }
                $current_child_id = $child_id[0];
                $next_child_id = "";
                $cat_result = array();
                $child_result = array();
                $prev_child_id = "";
                if ($curr_child_id != "") {
                    if (!in_array($curr_child_id, $child_id)) {
                        abort(404);
                    }
                    $current_child_id = $curr_child_id;
                }
                $tagged_friends = Tag_Parents::where('parent_id', $current_child_id)->orwhere('user_id', $current_child_id)->where('request_mode', '2')->get()->toArray();
                $friend_ids = array_merge(array_column($tagged_friends, 'user_id'), array_column($tagged_friends, 'parent_id'));
                $user_rank = "1";
                /* $fast_score = Helper::getUserFastScore($current_child_id); */
                $child_result = array();
                if (!empty($friend_ids)) {
                    array_push($friend_ids, $current_child_id);
                    DB::statement(DB::raw('set @rownumber=0'));
                    /* $child_result = new CountryWiseScore();
                      $child_result = $child_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'user_country_wise_score.*')->where('fast_score','!=','0')->whereIn('user_id', $friend_ids); */
                    $child_result = new User();
                    $child_result = $child_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'username', 'user_type', 'country_id', 'fast_score', DB::raw("(SELECT country_name FROM fi_countries WHERE fi_countries.id = country_id) as country_name"), 'id as user_id')->where('fast_score', '!=', '0')->whereIn('id', $friend_ids);
                    $child_result = $child_result->orderBy('fast_score', 'DESC')->get()->toArray();
                } else {
                    /* $child_result = new CountryWiseScore(); */
                    $child_result = new User();
                    $child_result = $child_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'username', 'user_type', 'country_id', 'fast_score', DB::raw("(SELECT country_name FROM fi_countries WHERE fi_countries.id = country_id) as country_name"), 'id as user_id')->where('fast_score', '!=', '0')->where('id', $current_child_id);
                    /* $child_result = $child_result::select(DB::raw("$user_rank as Rank"), 'user_country_wise_score.*')->where('fast_score','!=','0')->where('user_id', $current_child_id); */
                    $child_result = $child_result->orderBy('fast_score', 'DESC')->get()->toArray();
                }
                $childrecord = User::where('id', $current_child_id)->first();
                $current_index = array_search($current_child_id, $child_id);
                if (array_key_exists($current_index, $child_id)) {
                    if (array_key_exists($current_index + 1, $child_id)) {
                        $next_child_id = $child_id[$current_index + 1];
                    }
                    if (array_key_exists($current_index - 1, $child_id)) {
                        $prev_child_id = $child_id[$current_index - 1];
                    }
                }
                $testresult = TestResult::select('test_results.id as test_id', 'test_results.*')->selectRaw("IFNULL((SELECT MAX(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id<test_id AND fi_test_results.user_id = $current_child_id),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id>test_id AND fi_test_results.user_id = $current_child_id),'') as prev_id")->where('user_id', $current_child_id)->orderBy('test_results.id', 'DESC')->first();
                $share_result = array();
                if ($testresult) {
                    $cat_result = json_decode($testresult->categories_result, true);
                    if (!empty($cat_result)) {
                        foreach ($cat_result as $key => $value) {
                            $category_data = Category::select('category_name')->where('id', $value['category_id'])->first();
                            $cat_result[$key]['category_name'] = $category_data->category_name;
                        }
                    }

                    $fast_key = $childrecord->fast_key;
                    $share_result = Share::load($_ENV['APP_URL'] . "share/score/$fast_key", "My Child $childrecord->username fast Score " . $childrecord->fast_score)->services();
                } else {
                    $testresult = "";
                    if ($user->user_type == '2') {
                        $cat_result = DB::table('parent_categories')->get()->toArray();
                    } else if ($user->user_type == '3') {
                        $cat_result = DB::table('categories')->get()->toArray();
                    }
                }
                if ($curr_child_id == '') {
                    $curr_child_id = $current_child_id;
                }
                $current_user_data = user::find($curr_child_id);
                if ($current_user_data) {
                    $images = Parents::getAvtars($current_user_data);
                    if (!empty($images['images']) || $images['images'] != null) {
                        $array = $images['images'];
                        if (isset($instructor_avatar[3])) {
                            $img_name = $instructor_avatar[3];
                            if (!in_array($img_name, $images['images'])) {
                                $user->instructor_avatar = '';
                                $user->save();
                            }
                        }
                    } else {

                        $user->instructor_avatar = '';
                        $user->save();
                    }
                }else{
                    $images = "";
                }
                $fast_score = $user->fast_score;
                $summary = OverAllRange::where('min_range', '<=', $fast_score)->where('max_range', '>', $fast_score)->orwhere('max_range', '=', $fast_score)->select('summary')->first();

                return view('front_end.child', compact(['testresult', 'cat_result', 'childrecord', 'next_child_id', 'prev_child_id', 'share_result', 'child_result', 'summary', 'images']));
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : January 12, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to insight page for next links.
     * @params  : None
     * @return  : None
     */

    public function userTestData(Request $request) {
        try {
            $user = Auth::user();
            if ($request->semesterid && $request->sublevelid) {
                $data['testresult'] = TestResult::select('test_results.id as test_id', 'test_results.created_at', 'test_results.score', 'test_results.overall_interpretation', 'test_results.categories_result')->selectRaw("IFNULL((SELECT MAX(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id<test_id AND fi_test_results.user_id = $request->child_id AND fi_test_results.level_id = $user->level_id AND fi_test_results.sublevel_id = $request->sublevelid AND fi_test_results.sem_id = $request->semesterid),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id>test_id AND  fi_test_results.user_id = $request->child_id AND fi_test_results.level_id = $user->level_id AND fi_test_results.sublevel_id = $request->sublevelid AND fi_test_results.sem_id = $request->semesterid),'') as prev_id")->where('id', $request->id)->where('level_id', $user->level_id)->where('sublevel_id', $request->sublevelid)->where('sem_id', $request->semesterid)->first();
            } else {
                $data['testresult'] = TestResult::select('test_results.id as test_id', 'test_results.created_at', 'test_results.score', 'test_results.overall_interpretation', 'test_results.categories_result')->selectRaw("IFNULL((SELECT MAX(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id<test_id AND fi_test_results.user_id = $request->child_id),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id>test_id AND  fi_test_results.user_id = $request->child_id),'') as prev_id")->where('id', $request->id)->first();
            }

            if ($data['testresult']) {
                $cat_result = json_decode($data['testresult']->categories_result, true);
                if (!empty($cat_result)) {
                    foreach ($cat_result as $key => $value) {
                        $category_data = Category::select('category_name')->where('id', $value['category_id'])->first();
                        $cat_result[$key]['category_name'] = $category_data->category_name;
                    }
                }
                $data['category_result'] = $cat_result;
                return (json_encode(array('status' => 'success', 'data' => $data)));
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : January 12, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to insight page for next links.
     * @params  : None
     * @return  : None
     */

    public function parentTestData(Request $request) {
        try {
            $data['testresult'] = ParentTestResult::select('parent_test_results.id as test_id', 'parent_test_results.created_at', 'parent_test_results.score', 'parent_test_results.overall_interpretation', 'parent_test_results.categories_result')->selectRaw("IFNULL((SELECT MAX(fi_parent_test_results.id) FROM fi_parent_test_results WHERE fi_parent_test_results.id<test_id AND fi_parent_test_results.user_id = $request->child_id),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_parent_test_results.id) FROM fi_parent_test_results WHERE fi_parent_test_results.id>test_id AND  fi_parent_test_results.user_id = $request->child_id),'') as prev_id")->where('id', $request->id)->first();
            if ($data['testresult']) {
                $cat_result = json_decode($data['testresult']->categories_result, true);
                if (!empty($cat_result)) {
                    foreach ($cat_result as $key => $value) {
                        $category_data = ParentCategory::select('category_name')->where('id', $value['category_id'])->first();
                        $cat_result[$key]['category_name'] = $category_data->category_name;
                    }
                }
                $data['category_result'] = $cat_result;
                return (json_encode(array('status' => 'success', 'data' => $data)));
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : January 12, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is used for add a child view .
     * @params  : None
     * @return  : None
     */

    public function addchild() {
        try {
            $countries = Countries::all()->toArray();
            return view('admin.tagging.addchild', compact('countries', 'images'));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : January 12, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is used for tag a child view.
     * @params  : None
     * @return  : None
     */

    public function tagchild() {
        try {
            return view('admin.tagging.tagchild');
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : January 12, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is used for add new child from the registered child view.
     * @params  : None
     * @return  : None
     */

    public function saveChild(Request $request) {
        if ($request->ajax()) {
            try {
                /* ---------- Ajax Request for add plan --------- */

                $rules = array(
                    'country' => 'required',
                    'gender' => 'required',
                    'name' => 'required',
                    'age' => 'required',
                    'username' => 'required',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['country']))
                        $errorMsg = $failedRules['country'][0] . "\n";
                    if (isset($failedRules['gender']))
                        $errorMsg = $failedRules['gender'][0] . "\n";
                    if (isset($failedRules['name']))
                        $errorMsg = $failedRules['name'][0] . "\n";
                    if (isset($failedRules['age']))
                        $errorMsg = $failedRules['age'][0] . "\n";
                    if (isset($failedRules['username']))
                        $errorMsg = $failedRules['username'][0] . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {

                    $check = User::where(['username' => $request->username])->exists();
                    if ($check) {
                        return (json_encode(array('status' => 'error', 'message' => "Username has already been taken.")));
                    }
                    $addnew_user = new User;
                }
                $chars = 'ab$c3456DEFGHtuv#wxyzABCT466546defghijk@lmno%pqrsDEF6545GHtuv#wxyzABCTUVWXY*ZIEFGH45656tuv#wxyzABCTUVWJK0LMNOPQRS12789!';
                $pwd = substr(str_shuffle($chars), 0, 10);

                //                $tagid = 1;
                $usertype = 3;
                $addnew_user->user_type = $usertype;
                $addnew_user->country_id = $request->country;
                $addnew_user->school_name = $request->school_name;
                $addnew_user->contact = $request->contact;
                $addnew_user->name = $request->name;
                $addnew_user->username = $request->username;
                $addnew_user->email = $request->useremail;
                $addnew_user->gender = $request->gender;
                $level_id = "1";
                //                $age_level_data = AgeRangeLevel::where('min_age','<=',$request->age)->where('max_age','>=',$request->age)->first();
                $age_level_data = Levels::where('min_age', '<=', $request->age)->where('max_age', '>=', $request->age)->first();
                if ($age_level_data) {
                    $level_id = $age_level_data->id;
                }
                $addnew_user->level_id = $level_id;
                $addnew_user->age = $request->age;
                $addnew_user->password = Hash::make($pwd);

                /* ------------Save detasil in database ------ */
                if ($addnew_user->save()) {
                    $user = Auth::user();
                    Notification::send(User::find($user->id), new ChildPassword($pwd, $request->username));
                    $taggparrent = new Tag_Parents;
                    $taggparrent->user_id = $addnew_user->id;
                    $taggparrent->parent_id = $user->id;
                    $taggparrent->request_mode = "1";
                    $taggparrent->save();
                    $AddRequest = new AddRequest;
                    $AddRequest->from_id = $user->id;
                    $AddRequest->to_id = $addnew_user->id;
                    $AddRequest->request_status = "2";
                    $AddRequest->request_type = "1";
                    if ($AddRequest->save()) {
                        DB::table('user_notification')->insert(['from_id' => $user->id, 'to_id' => $addnew_user->id, 'message' => "$user->username added you join to fast test.", 'request_type' => '1']);
                    }
                    return (json_encode(array('status' => 'success', 'message' => sprintf('Add child successfully'))));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to Add New User'))));
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                $error_code = $ex->errorInfo[1];
                if ($error_code == 1062) {
                    $result = $ex->getMessage();
                    return (json_encode(array('status' => 'error', 'message' => 'User already exist')));
                } else {
                    Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                    return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
                }
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : January 24, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is used for refer friends.
     * @params  : None
     * @return  : None
     */

    public function referFriend(Request $request) {
        if ($request->ajax()) {
            try {
                $status = "success";
                $rules = array(
                    'searchname' => 'required',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['searchname']))
                        $errorMsg = $failedRules['searchname'][0] . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {
                    $parent_id = $request->id;
                    $fname = $request->searchname;
                    $search_type = $request->search_type;
                    $auth_name = Auth::user()->username;
                    $searchname = User::select('id', 'name', 'user_type', 'username')->where([['username', '=', $fname], ['user_type', '=', $search_type], ['username', '!=', $auth_name]])->first();
                    if (!empty($searchname)) {
                        return (json_encode(array('status' => $status, 'data' => $searchname)));
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => sprintf('Username not exist, please try another one'))));
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                $error_code = $ex->errorInfo[1];
                if ($error_code == 1062) {
                    $result = $ex->getMessage();
                    return (json_encode(array('status' => 'error', 'message' => 'Name already exist')));
                } else {
                    Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                    return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
                }
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : January 25, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is used for add child friend.
     * @params  : None
     * @return  : None
     */

    public function childFriend(Request $request) {
        if ($request->ajax()) {
            try {
                $status = "success";
                $current_user = Auth::user();
                $auth_id = $current_user->id;
                $user_type_request = $request->user_type;
                $friend_id = $request->friend_id;
                $result = AddRequest::where(['to_id' => $auth_id, 'from_id' => $friend_id])->orwhere(function ($query) use ($auth_id, $friend_id) {
                            $query->where('from_id', $auth_id)
                                    ->where('to_id', '=', $friend_id);
                        })->first();
                if (!$result) {
                    $tagfriend = new AddRequest();
                    if ($current_user->user_type == '2' && $user_type_request == '3') {
                        $tagfriend->to_id = $friend_id;
                        $tagfriend->from_id = $auth_id;
                        $tagfriend->request_type = '1';
                    } elseif ($current_user->user_type == '3' && $user_type_request == '3') {
                        $tagfriend->to_id = $friend_id;
                        $tagfriend->from_id = $auth_id;
                        $tagfriend->request_type = '2';
                    } elseif ($current_user->user_type == '2' && $user_type_request == '2') {
                        $tagfriend->to_id = $friend_id;
                        $tagfriend->from_id = $auth_id;
                        $tagfriend->request_type = '2';
                    } elseif ($current_user->user_type == '3' && $user_type_request == '2') {
                        $tagfriend->to_id = $friend_id;
                        $tagfriend->from_id = $auth_id;
                        $tagfriend->request_type = '1';
                    }
                    /* ---start save tag friend --- */
                    if ($tagfriend->save()) {
                        $user_data = User::where('id', $auth_id)->first();
                        DB::table('user_notification')->insert(['from_id' => $auth_id, 'to_id' => $friend_id, 'message' => "$user_data->username sent you friend request for tagging.", 'request_type' => $tagfriend->request_type]);
                        return (json_encode(array('status' => 'success', 'message' => sprintf('Refer friend successfully'))));
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to refer friend'))));
                    }
                    /* ---endsave tag friend --- */
                } else {
                    return (json_encode(array('status' => 'error', 'message' => 'You have already sent Request or invited by this user please see your notification.')));
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                $error_code = $ex->errorInfo[1];
                if ($error_code == 1062) {
                    $result = $ex->getMessage();
                    return (json_encode(array('status' => 'error', 'message' => 'Name already exist')));
                } else {
                    Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                    return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
                }
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

}
