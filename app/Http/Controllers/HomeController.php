<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;
use Response;
use Validator;
use App\Notifications\PasswordReset;
use Notification;
use App\User;
use App\Model\AddRequest;
use App\Model\Countries;
use App\Model\CountryWiseScore;
use App\Model\CountryScore;
use App\Model\Category;
use App\Model\ParentCategory;
use App\Model\TestResult;
use App\Model\ParentTestResult;
use App\Model\Tag_Parents;
use App\Model\OverAllRange;
use App\Model\SubLevels;
use App\Model\AgeRangeLevel;
use App\Model\Levels;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;
use App\Helpers\Helper;
use Exception;

class HomeController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | UserLoginController
      |--------------------------------------------------------------------------
      |
      | Here is user  login there accounts in  application.
      |
     */ /*
     * Create a new controller instance.
     *
     * @return void
     */

//    public function __construct() {
//        $this->middleware('auth')->except(['userLogin', 'forgetpassword', 'tokenverify', 'changePassword']);
//    }


    /*
     * @created : Jan 2, 2019
     * @author  : Nitish Kumar
     * @access  : public
     * @Purpose : This function is use to get all countries and show view of login page.
     * @params  : None
     * @return  : None
     */

    public function login(Request $request, $refer = "") {
        try {
//            $countries = Countries::all()->toArray();
            $countries = Countries::where('status', 1)->get();
            return view('login', compact('countries', 'refer'));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Jan 2, 2019
     * @author  : Anup Singh
     * @access  : public
     * @Purpose : welcome page before logged in first time
     * @params  : None
     * @return  : None
     */

    public function welcomePage() {
        try {
            return view('fast_welcome');
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Jan 2, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to view index page of UserLogin
     * @params  : None
     * @return  : None
     */
    /* ---------------------Display login form -------------------------- */

    public function index() {
        try {
            return view('admin.admin_login');
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Feb 12, 2019
     * @author  : Anup Singh
     * @access  : public
     * @Purpose : This function is use to view shared score page on social sites
     * @params  : Fast key
     * @return  : user details
     */

    public function userSharedScorePage($fast_key, Request $request) {
        try {
            $user_data = User::where('fast_key', $fast_key)->whereIn('user_type', [2, 3])->first();
            if ($user_data) {
                /* $fast_score = Helper::getUserFastScore($user_data->id); */
                if ($user_data->user_type == 2) {
                    $testresult = ParentTestResult::select('parent_test_results.score', 'parent_test_results.overall_interpretation', 'parent_test_results.duration', 'created_at', 'categories_result')->where('user_id', $user_data->id)->orderBy('parent_test_results.id', 'DESC')->first();
                } else {
                    $testresult = TestResult::select('test_results.score', 'test_results.overall_interpretation', 'test_results.duration', 'created_at', 'categories_result')->where('user_id', $user_data->id)->orderBy('test_results.id', 'DESC')->first();
                }

                $cat_result = array();
                if ($testresult) {
                    $cat_result = json_decode($testresult->categories_result, true);
                    if (!empty($cat_result)) {
                        foreach ($cat_result as $key => $value) {
                            if ($user_data->user_type == 2) {
                                $category_data = ParentCategory::select('category_name')->where('id', $value['category_id'])->first();
                            } else {
                                $category_data = Category::select('category_name')->where('id', $value['category_id'])->first();
                            }
                            $cat_result[$key]['category_name'] = $category_data->category_name;
                        }
                    }
                }
                $fast_score = $user_data->fast_score;
                $summary = OverAllRange::where('min_range', '<=', $fast_score)->where('max_range', '>', $fast_score)->orwhere('max_range', '=', $fast_score)->select('summary')->first();

                return view('share', compact(['user_data', 'testresult', 'cat_result', 'summary']));
            } else {
                abort(403);
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
     * @created : Jan 28, 2019
     * @author  : Anup Singh
     * @access  : public
     * @Purpose : This function is use to view profile page of Logged user
     * @params  : None
     * @return  : None
     */
    /* ---------------------Display profile form -------------------------- */

    public function profile() {
        try {
            $user = Auth::user();
            $countries = Countries::where('status', 1)->get();
            $level = DB::table('levels')->orderBy('priority', 'asc')->where('status', 1)->get()->toArray();
            /* ----- start code for change instructor avatar--- */
            $fast_score = $user->fast_score;
            $images = array();
            $range_id = OverAllRange::where('min_range', '<=', $fast_score)->where('max_range', '>', $fast_score)->orwhere('max_range', '=', $fast_score)->select('id')->first();
            if ($user->user_type == '2' && $user->gender == '1') {
                $avtars = OverAllRange::where('id', $range_id->id)->select('parent_male_avatar')->first();
                $images['images'] = json_decode($avtars->parent_male_avatar, true);
                $images['dir']['subdir'] = 'pmale';
            } else if ($user->user_type == '2' && $user->gender == '2') {
                $avtars = OverAllRange::where('id', $range_id->id)->select('parent_female_avatar')->first();
                $images['images'] = json_decode($avtars->parent_female_avatar, true);
                $images['dir']['subdir'] = 'pfemale';
            } else if ($user->user_type == '3' && $user->gender == '1') {
                $avtars = OverAllRange::where('id', $range_id->id)->select('child_male_avatar')->first();
                $images['images'] = json_decode($avtars->child_male_avatar, true);
                $images['dir']['subdir'] = 'cmale';
            } else if ($user->user_type == '3' && $user->gender == '2') {
                $avtars = OverAllRange::where('id', $range_id->id)->select('child_female_avatar')->first();
                $images['images'] = json_decode($avtars->child_female_avatar, true);
                $images['dir']['subdir'] = 'cfemale';
            } else {
                return false;
            }
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
            /* ------ end code for change instructor avatar -- */
            return view('profile', compact('user', 'level', 'images', 'countries'));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Jan 28, 2019
     * @author  : Anup Singh
     * @access  : public
     * @Purpose : This function is use to view profile page of Logged user
     * @params  : None
     * @return  : None
     */
    /* ---------------------Display profile form -------------------------- */

    public function adminprofile() {
        try {
            $user = Auth::user();
            return view('admin.profile.profile', compact('user'));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Feb 01, 2019
     * @author  : Nitish Kumar
     * @access  : public
     * @Purpose : This function is use to view update profile of Logged user
     * @params  : None
     * @return  : None
     */
    /* ---------------------Update  user profile -------------------------- */

    public function profileupdate(Request $request) {
        if ($request->ajax()) {
            try {
                $rules = array(
                    'name' => 'required | max:30',
                    'contact' => 'max:10',
                    'country_id' => 'required',
                    'school_name' => 'max:30',
                    'attached_file' => 'max:2048',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['name']))
                        $errorMsg = $failedRules['name'][0] . "\n";
                    if (isset($failedRules['contact']))
                        $errorMsg = $failedRules['contact'][0] . "\n";
                    if (isset($failedRules['attached_file']))
                        $errorMsg = "Please attach a file less than 2 MB" . "\n";
                    if (isset($failedRules['country_id']))
                        $errorMsg = $failedRules['country_id'][0] . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {
                    $user = Auth::user();
                    $id = Auth::user()->id;
                    if ($user) {
                        if (!empty($request->email)) {
                            $check = User::where(['email' => $request->email])
                                            ->where(function ($query) use ($id) {
                                                if (isset($id)) {
                                                    $query->where('id', '<>', $id);
                                                }
                                            })->exists();
                            if ($check) {
                                return (json_encode(array('status' => 'error', 'message' => sprintf('Email already exists, please try another one'))));
                            }
                        }
                        /* -- start coding of image file -- */
                        if ($request->hasFile('attached_file')) {
                            $image = $request->attached_file;
                            $filename = time() . '.' . $image->getClientOriginalExtension();
                            $type = $image->getClientOriginalExtension();
                            $allowed = array('jpg', 'png', 'jpeg');
                            if (!in_array(strtolower($type), $allowed)) {
                                return (json_encode(array('status' => 'error', 'message' => 'Please select only jpg, png or jpeg image')));
                            }
                            $path = storage_path('app/profile');
                            $image->move($path, $filename);
                            $image_name = $filename;
                            $user->avatar = $image_name;
                        }
                        /* -- end coding of image file -- */
                        $user->name = $request->name;
                        $user->email = $request->email;
                        $user->contact = $request->contact;
                        $user->country_id = $request->country_id;
                        $user->school_name = $request->school;
                        $user->level_id = $request->level;

                        if ($user->save()) {
                            return (json_encode(array('status' => 'success', 'message' => sprintf('Update profile successfully'))));
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to update user profile'))));
                        }
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => sprintf('Not found any profile'))));
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Feb 07, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use for change password from profile view.
     * @params  : None
     * @return  : None
     */
    /* ---------------------Change admin  profile password -------------------------- */

    public function changeAdminProfilePassword(Request $request) {
        if ($request->ajax()) {
            try {
                $user = Auth::user();
                $rules = array(
                    'oldpassword' => 'required | max:20',
                    'newpassword' => 'required | max:20',
                    'cpassoword' => 'required | max:20',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['oldpassword']))
                        $errorMsg = $failedRules['oldpassword'][0] . "\n";
                    if (isset($failedRules['newpassword']))
                        $errorMsg = $failedRules['newpassword'][0] . "\n";
                    if (isset($failedRules['cpassoword']))
                        $errorMsg = $failedRules['cpassoword'][0] . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {
                    if (!Hash::check($request->oldpassword, $user->password)) {
                        return (json_encode(array('status' => 'error', 'message' => sprintf('old password mismatched'))));
                    } else {
                        $user->password = Hash::make($request->newpassword);
                        if ($user->save()) {
                            return (json_encode(array('status' => 'success', 'message' => sprintf('Change password successfully'))));
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to changes password'))));
                        }
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Feb 06, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to view update profile of Logged user
     * @params  : None
     * @return  : None
     */
    /* ---------------------Update  admin profile -------------------------- */

    public function profileAdminupdate(Request $request) {
        if ($request->ajax()) {
            try {
                $rules = array(
                    'name' => 'required | max:30',
                    'contact' => 'max:10',
                    'school_name' => 'max:30',
                    'attached_file' => 'max:2048',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['name']))
                        $errorMsg = $failedRules['name'][0] . "\n";
                    if (isset($failedRules['contact']))
                        $errorMsg = $failedRules['contact'][0] . "\n";
                    if (isset($failedRules['attached_file']))
                        $errorMsg = "Please attach a file less than 2 MB" . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {
                    $id = $request->userid;
                    $user = User::select('id', 'name', 'email', 'contact', 'school_name')->where('id', $id)->first();
                    if ($user) {
                        $check = User::where(['email' => $request->email])
                                        ->where(function ($query) use ($id) {
                                            if (isset($id)) {
                                                $query->where('id', '<>', $id);
                                            }
                                        })->exists();
                        if ($check) {
                            return (json_encode(array('status' => 'error', 'message' => sprintf('Email already exists, please try another one'))));
                        }
                        /* -- start coding of image file -- */
                        if ($request->hasFile('attached_file')) {
                            $image = $request->attached_file;
                            $filename = time() . '.' . $image->getClientOriginalExtension();
                            $type = $image->getClientOriginalExtension();
                            $allowed = array('jpg', 'png', 'jpeg');
                            if (!in_array(strtolower($type), $allowed)) {
                                return (json_encode(array('status' => 'error', 'message' => 'Please select only jpg, png or jpeg image')));
                            }
                            $path = storage_path('app/profile');
                            $image->move($path, $filename);
                            $image_name = $filename;
                            $user->avatar = $image_name;
                        }
                        /* -- end coding of image file -- */
                        $user->name = $request->name;
                        $user->email = $request->email;
                        $user->contact = $request->contact;
                        $user->school_name = $request->school;
                        if ($user->save()) {
                            return (json_encode(array('status' => 'success', 'message' => sprintf('Update profile successfully'))));
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to update user profile'))));
                        }
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => sprintf('Not found any profile'))));
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Feb 01, 2019
     * @author  : Nitish Kumar
     * @access  : public
     * @Purpose : This function is use for change password from profile view.
     * @params  : None
     * @return  : None
     */
    /* ---------------------Change profile password -------------------------- */

    public function changeprofilePassword(Request $request) {
        if ($request->ajax()) {
            try {
                $user = Auth::user();
                $rules = array(
                    'oldpassword' => 'required | max:20',
                    'newpassword' => 'required | max:20',
                    'cpassoword' => 'required | max:20',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['oldpassword']))
                        $errorMsg = $failedRules['oldpassword'][0] . "\n";
                    if (isset($failedRules['newpassword']))
                        $errorMsg = $failedRules['newpassword'][0] . "\n";
                    if (isset($failedRules['cpassoword']))
                        $errorMsg = $failedRules['cpassoword'][0] . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {
                    if (!Hash::check($request->oldpassword, $user->password)) {
                        return (json_encode(array('status' => 'error', 'message' => sprintf('old password mismatched'))));
                    } else {
                        $user->password = Hash::make($request->newpassword);
                        if ($user->save()) {
                            return (json_encode(array('status' => 'success', 'message' => sprintf('Change password successfully'))));
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to changes password'))));
                        }
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Jan 28, 2019
     * @author  : Anup Singh
     * @access  : public
     * @Purpose : This function is use to view fast score line chart Logged user
     * @params  : None
     * @return  : None
     */
    /* ---------------------Display Chart Data -------------------------- */

    public function getchartData(Request $request) {
        try {
            $user = Auth::user();
            $level_id = $user->level_id;
            $sublevel_data = SubLevels::select('id as subId', 'sublevel_name', DB::raw("(SELECT SUM(test_score) FROM fi_user_fast_score WHERE user_id = $user->id AND level_id = $user->level_id AND sublevel_id = subId) as total_score"), DB::raw("(SELECT SUM(prev_score) FROM fi_user_fast_score WHERE user_id = $user->id AND level_id = $user->level_id AND sublevel_id = subId) as prev_total_score"), DB::raw("(SELECT SUM(last_test_score) FROM fi_user_fast_score WHERE user_id = $user->id AND level_id = $user->level_id AND sublevel_id = subId) as last_test_score"))->orderBy('priority', 'ASC')->get();
            return json_encode($sublevel_data);
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Jan 28, 2019
     * @author  : Anup Singh
     * @access  : public
     * @Purpose : This function is use to view fast score line chart Logged user
     * @params  : None
     * @return  : None
     */
    /* ---------------------Display Chart Data -------------------------- */

    public function parentchartData(Request $request) {
        try {
//            $currentMonth = date('m');
//            $data = ParentTestResult::select('scores')->whereMonth('created_at', Carbon::now()->month)->where('user_id', $request->id)->get()->toArray();
            $data = ParentTestResult::select('score')->where('user_id', $request->id)->get()->toArray();
            return json_encode($data);
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    public function getchartSubLevelData(Request $request) {
        try {
            $user = Auth::user();
            $level_id = $user->level_id;
            $sub_name = $request->sub_name;
            $sublevel_data = SubLevels::where('sublevel_name', $sub_name)->first();
            if ($request->index_val == '2') {
                $score_data = DB::table('user_fast_score')->select(DB::raw("(SELECT SUM(test_score) FROM fi_user_fast_score WHERE user_id = $user->id AND level_id = $user->level_id AND sublevel_id = $sublevel_data->id) as total_score"), DB::raw("(SELECT GROUP_CONCAT(sem_name) FROM fi_semesters WHERE sublevel_id = $sublevel_data->id ORDER BY fi_semesters.priority) as sem_name"))->where('user_id', $user->id)->first();
                $sem_score = DB::table('user_fast_score')->join('semesters', 'semesters.id', '=', 'user_fast_score.sem_id')->select('user_fast_score.test_score')->where(['user_fast_score.user_id' => $user->id, 'user_fast_score.level_id' => $level_id, 'user_fast_score.sublevel_id' => $sublevel_data->id])->get()->toArray();
            } else if ($request->index_val == '1') {
                $score_data = DB::table('user_fast_score')->select(DB::raw("(SELECT SUM(prev_score) FROM fi_user_fast_score WHERE user_id = $user->id AND level_id = $user->level_id AND sublevel_id = $sublevel_data->id) as total_score"), DB::raw("(SELECT GROUP_CONCAT(sem_name) FROM fi_semesters WHERE sublevel_id = $sublevel_data->id ORDER BY fi_semesters.priority) as sem_name"))->where('user_id', $user->id)->first();
                $sem_score = DB::table('user_fast_score')->join('semesters', 'semesters.id', '=', 'user_fast_score.sem_id')->selectRaw('IFNULL(prev_score,"0") as test_score')->where(['user_fast_score.user_id' => $user->id, 'user_fast_score.level_id' => $level_id, 'user_fast_score.sublevel_id' => $sublevel_data->id])->get()->toArray();
            } else if ($request->index_val == '0') {
                $score_data = DB::table('user_fast_score')->select(DB::raw("(SELECT SUM(last_test_score) FROM fi_user_fast_score WHERE user_id = $user->id AND level_id = $user->level_id AND sublevel_id = $sublevel_data->id) as total_score"), DB::raw("(SELECT GROUP_CONCAT(sem_name) FROM fi_semesters WHERE sublevel_id = $sublevel_data->id ORDER BY fi_semesters.priority) as sem_name"))->where('user_id', $user->id)->first();
                $sem_score = DB::table('user_fast_score')->join('semesters', 'semesters.id', '=', 'user_fast_score.sem_id')->selectRaw('IFNULL(last_test_score,"0") as test_score')->where(['user_fast_score.user_id' => $user->id, 'user_fast_score.level_id' => $level_id, 'user_fast_score.sublevel_id' => $sublevel_data->id])->get()->toArray();
            }
            return Response::json(array('score_data' => $score_data, 'sem_score' => $sem_score));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : apr 08, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to view fast score line chart parent Logged user
     * @params  : None
     * @return  : None
     */
    /* ---------------------Display Global Chart Data -------------------------- */

    public function parentGlobalRankingChartData(Request $request) {
        try {
            $currentMonth = date('m');
            $user = Auth::user();
            $data = array();
            $countries = CountryScore::select('country_id')->get()->toArray();
            $ids = array_column($countries, 'country_id');
            $user_score = "0";
            $user_data = ParentTestResult::select('score')->where('user_id', $user->id)->orderBy('parent_test_results.id', 'DESC')->first();
            if ($user_data) {
                $user_score = $user_data->score;
            }
            $score = \DB::table('country_score')->whereIn('country_id', $ids)
                            ->join('countries', 'countries.id', '=', 'country_score.country_id')
                            ->select('country_score.id', 'country_score.score', 'countries.country_name')->get()->toArray();
            $data['scores'] = $score;
            $data['your'] = $user_score;
            return json_encode($data);
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : feb 02, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to view fast score line chart Logged user
     * @params  : None
     * @return  : None
     */
    /* ---------------------Display Global Chart Data -------------------------- */

    public function globalRankingChartData(Request $request) {
        try {
            $currentMonth = date('m');
            $user = Auth::user();
            $data = array();
            $score = User::join('countries', 'countries.id', '=', 'users.country_id')
                            ->select('countries.id as countryId', DB::raw("(SELECT AVG(fast_score) FROM fi_users WHERE fast_score != '0' AND country_id = countryId) as score"), 'countries.country_name')->where('users.fast_score', '!=', '0')->where('users.user_type', $user->user_type)->groupBy('users.country_id')->get()->toArray();
            $data['scores'] = $score;
            $data['your'] = $user->fast_score;
            return json_encode($data);
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /* ---------------------user login -------------------------- */
    /*
     * @created : Jan 2, 2019
     * @author  : Mohd Nadeem
     * @access  : protected
     * @Purpose : This function is use to check user login if success then redirect to home else return error.
     * @params  : None
     * @return  : home page if success
     */

    protected function userLogin(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required',
                    'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        } else {
            try {
                $remember = $request->remember;
                if (Auth::attempt(['email' => request('email'), 'password' => request('password')], $remember) || (Auth::attempt(['username' => request('email'), 'password' => request('password')], $remember))) {
                    $user = Auth::user();
                    \Session::flash('name', Auth::user()->name);
                    \Session::flash('email', Auth::user()->email);
                    if ($user->user_type == '1') {
                        return redirect()->intended('home');
                    } else if ($user->user_type == '2' || $user->user_type == '3') {
                        if ($user->logged_in == '2') {
                            User::where('id', $user->id)->update(['logged_in' => '1']);
                            return redirect()->intended('welcome');
                        } else {
                            if ($user->user_type == '2') {
                                return redirect()->route('parent_overview');
                            } else {
                                return redirect()->intended('overview');
                            }
                        }
                    } else {
                        return view('/');
                    }
                } else {
                    \Session::flash('message', 'Username or password do not match');
                    return redirect('/');
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        }
    }

    /* ---------------------user Notify Data -------------------------- */
    /*
     * @created : Jan 29, 2019
     * @author  : Anup Singh
     * @access  : protected
     * @Purpose : This function is use to Know the notification data of user.
     * @params  : None
     * @return  : None
     */

    public function getUserData(Request $request) {
        try {
            $data['notification_data'] = \DB::table('user_notification')->select('id', 'message', 'status', 'request_type', 'created_at')->where('to_id', $request->user_id)->where('status', '2')->get();

            $data['notification_data'] = $data['notification_data']->map(function ($value) {
                $data['id'] = $value->id;
                $data['message'] = $value->message;
                $data['status'] = $value->status;
                $data['request_type'] = $value->request_type;
                if ($value->created_at != '') {
                    date_default_timezone_set("Singapore");
                    $time_ago = strtotime($value->created_at);
                    $current_time = time();
                    $time_difference = $current_time - $time_ago;
                    $seconds = $time_difference;
                    $minutes = round($seconds / 60); // value 60 is seconds  
                    $hours = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
                    $days = round($seconds / 86400); //86400 = 24  60  60;  
                    $weeks = round($seconds / 604800); // 7*24*60*60;  
                    $months = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
                    $years = round($seconds / 31553280); //(365+365+365+365+366)/5  24  60 * 60
                    if ($seconds <= 60) {
                        $data['time'] = "Just Now";
                    } else if ($minutes <= 60) {
                        if ($minutes == 1) {
                            $data['time'] = "one minute ago";
                        } else {
                            $data['time'] = "$minutes minutes ago";
                        }
                    } else if ($hours <= 24) {
                        if ($hours == 1) {
                            $data['time'] = "an hour ago";
                        } else {
                            $data['time'] = "$hours hrs ago";
                        }
                    } else if ($days <= 7) {
                        if ($days == 1) {
                            $data['time'] = "yesterday";
                        } else {
                            $data['time'] = "$days days ago";
                        }
                    } else if ($weeks <= 4.3) {
                        if ($weeks == 1) {
                            $data['time'] = "a week ago";
                        } else {
                            $data['time'] = "$weeks weeks ago";
                        }
                    } else if ($months <= 12) {
                        if ($months == 1) {
                            $data['time'] = "a month ago";
                        } else {
                            $data['time'] = "$months months ago";
                        }
                    } else {
                        if ($years == 1) {
                            $data['time'] = "one year ago";
                        } else {
                            $data['time'] = "$years years ago";
                        }
                    }
                }
                return $data;
            });
            $data['notification_data']->all();
            $data['total_notification'] = count($data['notification_data']);
            $data['request_data'] = AddRequest::select('user_tag_request.request_status', 'user_tag_request.from_id', 'from.username as from_user', 'from.user_type as from_user_type', 'to.username as to_user', 'to.user_type as to_user_type')->selectRaw("IF((fi_user_tag_request.from_id='$request->user_id'),'invited','invites') as status_message")->join('users as from', 'from.id', '=', 'user_tag_request.from_id')->join('users as to', 'to.id', '=', 'user_tag_request.to_id')->where('to_id', $request->user_id)->where('request_status', '1')->get()->toArray();

            return json_encode($data);
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Jan 29, 2019
     * @author  : Anup Singh
     * @access  : protected
     * @Purpose : This function is use to view the response of tagging parent and child.
     * @params  : None
     * @return  : None
     */

    public function responseUserRequest(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                        'from_id' => 'required|numeric',
                        'type' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                \Session::flash('emailvereify', "enter a valid email.");
                return redirect('/')->withErrors($validator)->withInput();
            } else {
                $user = Auth::user();
                $form_id = user::find($request->from_id);
                if (AddRequest::where(['from_id' => $request->from_id, 'to_id' => $user->id])->exists()) {
                    if ($request->type == '2') {
                        $result = "Accepted successfully";
                        AddRequest::where(['from_id' => $request->from_id, 'to_id' => $user->id])->update(['request_status' => '2']);
                        if ($user->user_type == '2' && $form_id->user_type == '2') {
                            DB::table('user_notification')->insert(['from_id' => $user->id, 'to_id' => $request->from_id, 'message' => "$user->username accepted your friend request for tagging.", 'request_type' => '2']);
                            Tag_Parents::insert(['user_id' => $user->id, 'parent_id' => $request->from_id, 'request_mode' => '2']);
                        } elseif ($user->user_type == '3' && $form_id->user_type == '2') {
                            DB::table('user_notification')->insert(['from_id' => $user->id, 'to_id' => $request->from_id, 'message' => "$user->username accepted your friend request for tagging.", 'request_type' => '1']);
                            Tag_Parents::insert(['user_id' => $user->id, 'parent_id' => $request->from_id, 'request_mode' => '1']);
                        } elseif ($user->user_type == '2' && $form_id->user_type == '3') {
                            DB::table('user_notification')->insert(['from_id' => $user->id, 'to_id' => $request->from_id, 'message' => "$user->username accepted your friend request for tagging.", 'request_type' => '1']);
                            Tag_Parents::insert(['user_id' => $request->from_id, 'parent_id' => $user->id, 'request_mode' => '1']);
                        } elseif ($user->user_type == '3' && $form_id->user_type == '3') {
                            DB::table('user_notification')->insert(['from_id' => $user->id, 'to_id' => $request->from_id, 'message' => "$user->username accepted your friend request for tagging.", 'request_type' => '2']);
                            Tag_Parents::insert(['user_id' => $user->id, 'parent_id' => $request->from_id, 'request_mode' => '2']);
                        }
                    }
                    if ($request->type == '3') {
                        $result = "Declined successfully";
                        AddRequest::where(['from_id' => $request->from_id, 'to_id' => $user->id])->update(['request_status' => '3']);
//                        if ($user->user_type == '2' && $form_id->user_type == '2') {
//                            DB::table('user_notification')->insert(['from_id' => $user->id, 'to_id' => $friend_id, 'message' => "$user->username declined your friend request for tagging.", 'request_type' => '2']);
//                        } elseif ($user->user_type == '3' && $form_id->user_type == '2') {
//                            DB::table('user_notification')->insert(['from_id' => $user->id, 'to_id' => $friend_id, 'message' => "$user->username declined your friend request for tagging.", 'request_type' => '1']);
//                        } elseif ($user->user_type == '2' && $form_id->user_type == '3') {
//                            DB::table('user_notification')->insert(['from_id' => $user->id, 'to_id' => $friend_id, 'message' => "$user->username declined your friend request for tagging.", 'request_type' => '1']);
////                            
//                        }
                    }
                    return (json_encode(array('status' => 'success', 'message' => $result)));
                }
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /* --------------- Its Used for logout user---------------------- */
    /*
     * @created : Jan 2, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to logout  user all sesstion destroy.
     * @params  : None
     * @return  : login page
     */

    public function getlogout() {
        try {
            Auth::logout();
            Session::flush();
            return redirect('/');
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Jan 2, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to chnage password user.
     * @params  : None
     * @return  : login page
     */

    public function changePassword(Request $request) {
        try {
            $chars = 'ab$c3456DEFGHtuv#wxyzABCT466546defghijk@lmno%pqrsDEF6545GHtuv#wxyzABCTUVWXY*ZIEFGH45656tuv#wxyzABCTUVWJK0LMNOPQRS12789!';
            $token = substr(str_shuffle($chars), 0, 50);
            $user_Id = $request->userId;
            $userObj = User::find($user_Id);
            $userObj->password = Hash::make($request->confirmPassword);
            $userObj->remember_token = $token;
            if ($userObj->save()) {
                \Session::flash('message', "Your password has been changed successfully.");
                return redirect('/');
            } else {
                \Session::flash('message', "Somthing went wrong please try again.");
                return redirect('/');
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
     * @created : Jan 2, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to display password reset form.
     * @params  : None
     * @return  : form
     */

    public function ShowResetFormLink($token, Request $request) {
        try {
            return view('mail.password.forget_password', ['token' => $token]);
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Jan 2, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is used to verify the token for email id.
     * @params  : None
     * @return  : form
     */

    public function tokenverify(Request $request) {
        try {
// $verify = User::where('remember_tokenm',$token)->whereRaw('updated_at >= now() - interval ? minute',[5])->first();
            $verify = User::where('email', $request->email);
            $vcount = $verify->count();
            if ($verify != '' && $vcount > 0) {
                $reset = \DB::table('password_resets')
                                ->where('email', $request->email)
                                ->where('token', $request->token)->first();
                $userId = $verify->first()->id;
                $userEmail = $verify->first()->email;
                return view('mail.password.reset_form', ['userId' => $userId, 'userEmail' => $userEmail]);
            } else {
                \Session::flash('message', "Token has been expired please try again or please enter a valid email id!");
                return redirect('/');
//return view('auth.reset_password');
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
     * @created : Jan 2, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is used for the reset password. 
     * @params  : None
     * @return  : form
     */

    public function forgetpassword(Request $request) {
        try {
            $chars = 'abc3456DEFGHtuvwxyzABCT466546defghijk@lmnopqrsDEF6545GwxyzABCTUVWXY*ZIEFGH45656tuvwxyzABCTUVWJK0LMNOPQRS12789';
            $token = substr(str_shuffle($chars), 0, 50);
            $validator = Validator::make($request->all(), [
                        'email' => 'required'
            ]);
            if ($validator->fails()) {
                \Session::flash('emailvereify', "enter a valid email.");
                return redirect('/')->withErrors($validator)->withInput();
            }
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $data = array(
                    'token' => $token,
                    'email' => $request->email
                );
                $result = \DB::table('password_resets')->insert($data);
                if ($request) {
                    $users = User::find($user->id);
                    $users->remember_token = $token;
                    $users->save();
                }
                Notification::send(User::find($user->id), new PasswordReset($token));
                \Session::flash('message', "Your password reset link has been send.");
                return redirect('/');
            } else {
                \Session::flash('message', "This Email it did not match in our record please try with correct email.");
                return redirect('/');
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
     * @created : Jan 21, 2019
     * @author  : Nitish Kumar
     * @access  : public
     * @Purpose : This function is use to Add user from signup page.
     * @params  : None
     * @return  : login page
     */

    public function Adduser(Request $request, $key) {
        if ($request->ajax()) {
            try {
// ---------- Ajax Request for add plan --------- //
                $rules = array(
                    'country' => 'required',
                    'user_type' => 'required',
                    'username' => 'required',
                    'userpassword' => 'required',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['country']))
                        $errorMsg = $failedRules['country'][0] . "\n";
                    if (isset($failedRules['user_type']))
                        $errorMsg = $failedRules['user_type'][0] . "\n";
                    if (isset($failedRules['username']))
                        $errorMsg = $failedRules['username'][0] . "\n";
                    if (isset($failedRules['userpassword']))
                        $errorMsg = $failedRules['userpassword'][0] . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {

                    $refer_id = "";
                    $check_key = User::select('id')->where('fast_key', $key)->first();
                    if ($check_key) {
                        $refer_id = $check_key->id;
                    }

                    $check = User::where(['username' => $request->username])->exists();
                    if ($check) {
                        return (json_encode(array('status' => 'error', 'message' => "The username has already been taken.")));
                    }
                    if (!empty($request->useremail)) {
                        $checkemail = User::where(['email' => $request->useremail])->exists();
                        if ($checkemail) {
                            return (json_encode(array('status' => 'error', 'message' => sprintf('Email already exists, please try another one'))));
                        }
                    }
                    $addnew_user = new User;
                    $addnew_user->user_type = $request->user_type;
                    $addnew_user->country_id = $request->country;
//                    $addnew_user->school_name = $request->school_name;
//                    $addnew_user->contact = $request->contact;
                    $addnew_user->name = $request->username;
                    $addnew_user->username = $request->username;
                    $addnew_user->email = $request->username;
//                    $addnew_user->age = $request->age;
//                    $addnew_user->gender = $request->gender;
                    $level_id = "1";
//                    $age_level_data = AgeRangeLevel::where('min_age','<=',$request->age)->where('max_age1','>=',$request->age)->first();
//                    $age_level_data = Levels::where('min_age', '<=', $request->age)->where('max_age', '>=', $request->age)->first();
//                    if ($age_level_data) {
//                        $level_id = $age_level_data->id;
//                    }
                    $addnew_user->level_id = $level_id;
                    $addnew_user->refer_id = $refer_id;
                    $addnew_user->password = Hash::make($request->userpassword);
                    /* ------------Save detasil in database ------ */
                    if ($addnew_user->save()) {

                        \Session::flash('success', 'User Successfully Created , please login');
                        return (json_encode(array('status' => 'success', 'message' => sprintf('User Successfully Created'))));
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to Add New User'))));
                    }
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

    /* update gender and age range */

    public function updateGenderAgeAfterLogin(Request $request) {
        if ($request->ajax()) {
            try {
                $rules = array(
                    'gender' => 'required',
                    'age' => 'required',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['gender']))
                        $errorMsg = $failedRules['gender'][0] . "\n";
                    if (isset($failedRules['age']))
                        $errorMsg = $failedRules['age'][0] . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                } else {
                    
                    $id = Auth::user()->id;
                     $age_level_data = Levels::where('min_age','<=',$request->age)->where('max_age','>=',$request->age)->first();
//                    
                    $update_user = User::find($id);
                     if ($age_level_data) {
                        $level_id = $age_level_data->id;
                    }
                    $update_user->level_id = $level_id;
                    $update_user->age = $request->age;
                    $update_user->gender = $request->gender;
                    if ($update_user->save()) {
                        return (json_encode(array('status' => 'success', 'message' => sprintf('User Successfully Updated'))));
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to Add New User'))));
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                $error_code = $ex->errorInfo[1];
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Jan 21, 2019
     * @author  : Nitish Kumar
     * @access  : public
     * @Purpose : This function is used to check availability of username for the the new user.
     * @params  : None
     * @return  : login page
     */

    /* ---- user availability ------------------------ */

    public function Useravailability(Request $request) {

        try {
            if ($request->ajax()) {
                $user_type = $request->user_type;
                if ($user_type == 2) {
                    $rules = array('email' => 'unique:users');
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $failedRules = $validator->getMessageBag()->toArray();
                        $errorMsg = "";
                        if (isset($failedRules['email'])) {
                            $errorMsg = $failedRules['email'][0] . "\n";
                        }
                        return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                    } else {
                        return (json_encode(array('status' => 'success', 'message' => "User Email available")));
                    }
                } else if ($user_type == 3) {
                    $rules = array('username' => 'unique:users');
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $failedRules = $validator->getMessageBag()->toArray();
                        $errorMsg = "";
                        if (isset($failedRules['username'])) {
                            $errorMsg = $failedRules['username'][0] . "\n";
                        }
                        return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                    } else {
                        $check = User::where(['email' => $request->username])->exists();
                        if ($check) {
                            return (json_encode(array('status' => 'error', 'message' => "The email has already been taken.")));
                        }
                        return (json_encode(array('status' => 'success', 'message' => "User Name available")));
                    }
                }
            } else {
                abort(404);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /* -------------get user data ----------- */
    /*
     * @created : Feb 05, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use display total users.
     * @params  : None
     * @return  : dashboard
     */

    public function getAllUsersdata() {
        try {
            $perpage = '';
            $page = '';
            $offset = 0;
            $draw = '';
            $status = '';
            $n = '';
            $users = User::getAllUsers($perpage, $page, $offset, $draw, $status, $n);
            $users = $users->toArray();
            if (!empty($users)) {
                $total_users = count($users);
                $user_type = array_column($users, 'user_type');
                $parent_users = count(array_keys($user_type, "2"));
                $child_users = count(array_keys($user_type, "3"));
                return (json_encode(array('status' => 'success', 'total_users' => $total_users, 'parent_users' => $parent_users, 'child_users' => $child_users)));
            }
            return (json_encode(array('status' => 'error', 'message' => 'No data found')));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /* ----------------------- NotificationStatus --------------- */
    /*
     * @created : Feb 11, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to change notification status.
     * @params  : None
     * @return  : None
     */

    public function ChangeNotificationStatus(Request $request) {
        if ($request->ajax()) {
            try {
                if ($request->id) {
                    $status = \DB::table('user_notification')->select('status')->where('id', $request->id)->first();
                    if ($status->status == 2) {
                        DB::table('user_notification')->where('id', $request->id)->delete();
                        return (json_encode(array('status' => 'success', 'message' => "Read Successfully")));
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => " not read successfull")));
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /* ----------------------- Mark all Notification  Read--------------- */
    /*
     * @created : Feb 12, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to mark all notification read status.
     * @params  : None
     * @return  : None
     */

    public function MarkAllNotificationRead(Request $request) {
        if ($request->ajax()) {
            try {
                $user = Auth::user();
                if ($user) {
                    $status = \DB::table('user_notification')->select('status')->where('to_id', $user->id)->get();
                    if ($status) {
                        DB::table('user_notification')->where('to_id', $user->id)->update(['status' => 1]);
                        return (json_encode(array('status' => 'success', 'message' => "Read Successfully")));
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => " not read successfull")));
                    }
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

}
