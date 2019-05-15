<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\TestResult;
use App\Model\ParentTestResult;
use Illuminate\Http\Request;
use App\Model\Questions;
use DB;
use App\Model\Answers;
use Session;
use Response;
use Validator;
use Auth;
use App\Model\Tag_Parents;
use App\User;
use App\Helpers\Helper;
use App\Model\AddRequest;
use App\Model\Parents;
use App\Model\Category;
use App\Model\ParentCategory;
use App\Model\Countries;
use App\Model\CountryWiseScore;
use App\Notifications\TestRequest;
use App\Model\Semester;
use Share;
use Notification;
use Carbon\Carbon;
use Exception;

class ParentsController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | ParentsController
      |--------------------------------------------------------------------------
      |
      | Here we can get all the parent and child test score. These
      | controller used to get the current score for the child and
      | parent layout pages.
     */

    public function __construct() {
        $this->middleware('auth');
    }

    /*
     * @created : January 12, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view index page of overview.
     * @params  : None
     * @return  : None
     */

    public function index(Request $request) {
        try {
            $user = Auth::user();
            $id = $user->id;
            $fast_score = $user->fast_score;
            $instructor_avatar = explode("/", $user->instructor_avatar);
            $limit = Helper::getRetakeTestLimit($id);

            /* $fast_score = Helper::getUserFastScore($user->id); */
            $level = TestResult::getlevels();
            $images = Parents::getAvtars($user);

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

            $sublevels = TestResult::getSublevels();
            $data = TestResult::overviewlayout($request, $id, $fast_score);
            if ($data) {
                $testresult = $data['testresult'];
                $cat_result = $data['cat_result'];
                $summary = $data['summary'];
            } else {
                $cat_result = Category::where('level_id',$user->level_id)->get();
               
            }
            /* -- start level, sublevel and semester for the overview page --------- */

            $level_id = $user->level_id;
            $user_test_data = DB::table('user_level_data')->where('userId', $user->id)->first();
            if ($user_test_data) {
                if ($user_test_data->last_sem != null) {
                    $sem_id = DB::select("(SELECT fi_semesters.id FROM `fi_semesters` WHERE fi_semesters.sublevel_id = $user_test_data->current_sublevel AND fi_semesters.id > $user_test_data->last_sem ORDER BY priority DESC LIMIT 1) UNION (SELECT fi_semesters.id FROM fi_semesters WHERE fi_semesters.sublevel_id = (SELECT fi_sublevels.id FROM fi_sublevels WHERE fi_sublevels.id>$user_test_data->current_sublevel ORDER BY priority ASC LIMIT 1) ORDER BY fi_semesters.priority ASC LIMIT 1)");

                    if (!empty($sem_id)) {
                        $semester = Semester::join('sublevels', 'semesters.sublevel_id', '=', 'sublevels.id')->select('semesters.id as SemID', 'semesters.sem_name', 'semesters.sublevel_id', 'sublevels.sublevel_name', DB::raw("(select level_name from fi_levels where id = $level_id) as level_name"), DB::raw("(select id from fi_levels where id = $level_id) as levelid"))->where('semesters.status', '1')->where('semesters.id', $sem_id[0]->id)->get()->toArray();
                    }
                } else {
                    $semester = Semester::join('sublevels', 'semesters.sublevel_id', '=', 'sublevels.id')->select('semesters.id as SemID', 'semesters.sem_name', 'semesters.sublevel_id', 'sublevels.sublevel_name', DB::raw("(select level_name from fi_levels where id = $level_id) as level_name"), DB::raw("(select id from fi_levels where id = $level_id) as levelid"))->where('semesters.status', '1')->where('semesters.sublevel_id', $user_test_data->current_sublevel)->orderBy('semesters.priority', 'ASC')->limit(1)->get()->toArray();
                }
            }

            /* -- end level, sublevel and semester for the overview page --------- */
            $share_result = array();

            if (!empty($testresult)) {
                $fast_key = Auth::user()->fast_key;
                $share_result = Share::load(url('/') . "/share/score/$fast_key", 'My fast Score ' . $user->fast_score)->services();
            } else {
                $testresult = "";
            }
            return view('front_end.overview', compact(['cat_result', 'share_result', 'limit', 'level', 'user', 'sublevels', 'summary', 'semester','images']))->with(['testresult' => $testresult]);
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            $err_result = $e->getMessage();
            return (json_encode(array('status' => 'error', 'message' => $err_result)));
        }
    }

    /*
     * @created : April 05, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view index page of parent overview.
     * @params  : None
     * @return  : None
     */

    public function parentOverview(Request $request) {
        try {
            $user = Auth::user();
            $limit = Helper::getRetakeTestLimit($user->id);
            $images = Parents::getAvtars($user);
            if (!empty($images['images']) || $images['images'] != null) {
                $array = $images['images'];
                if (isset($instructor_avatar[3])){
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
            $data = ParentTestResult::overviewlayout($request, $user->id, $user->fast_score);
            if ($data) {
                $testresult = $data['testresult'];
                $cat_result = $data['cat_result'];
                $summary = $data['summary'];
            } else {
                $cat_result = DB::table('parent_categories')->get()->toArray();
            }

            $share_result = array();
            if (!empty($testresult)) {
                $fast_key = $user->fast_key;
                $share_result = Share::load(url('/') . "/share/score/$fast_key", 'My fast Score ' . $testresult->score)->services();
            } else {
                $testresult = "";
            }
            //print_r($share_result); die;
            return view('parent.overview', compact(['cat_result', 'share_result', 'user', 'limit', 'summary', 'images']))->with(['testresult' => $testresult]);
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            $err_result = $e->getMessage();
            return (json_encode(array('status' => 'error', 'message' => $err_result)));
        }
    }

    /*
     * @created : January 12, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to listing of tagged user.
     * @params  : None
     * @return  : None
     */

    public function getAllUserRequest($type, Request $request) {
        try {
            $perpage = $request->datatable['pagination']['perpage'];
            $page = $request->datatable['pagination']['page'];
            $draw = (isset($request->datatable['pagination']['draw']) && ($request->datatable['pagination']['draw'] != "") ? $request->datatable['pagination']['draw'] : '1');
            if ($page == '1') {
                $offset = 0;
            } else {
                $offset = ($page - 1) * $perpage;
            }
            $user = Auth::user();
            $user_request = new AddRequest();
            DB::statement(DB::raw('set @rownumber=' . $offset . ''));
            $user_request = $user_request->select(DB::Raw('@rownumber:=@rownumber+1 as S_No'), 'id', 'from_id', 'to_id', DB::raw("(select username from fi_users where id = from_id) as from_name"), DB::raw("(select username from fi_users where id = to_id) as to_name"), 'request_status')->selectRaw("IF((fi_user_tag_request.from_id=$user->id),'1','2') as from_status")->where('request_type', $type)->where(function ($query) use ($user) {
                $query->where('from_id', $user->id)
                        ->orWhere('to_id', $user->id);
            });
            $total = $user_request->count();
            $user_request = $user_request->offset($offset)->limit($perpage)->get();
            $meta = ['perpage' => $perpage, 'total' => $total, 'page' => $page];
            return Response::json(array('data' => $user_request, 'meta' => $meta));
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
     * @Purpose : This function is use to view all child request page.
     * @params  : None
     * @return  : None
     */

    public function manageRequestPage($type, Request $request) {
        try {
            if ($type == '2' || $type == '1') {
                $user = Auth::user();
                $countries = new Countries();
                $countries = $countries->select('id', 'country_name')->where('status', 1)->get();
                return view('front_end.manage_child_friend', compact(['user', 'type', 'countries']));
            } else {
                return abort(404);
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
     * @created : Feb 08, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to untagging.
     * @params  : None
     * @return  : None
     */

    public function UntagUser(Request $request) {
        if ($request->ajax()) {
            try {

                if ($request->id) {
                    $untag = AddRequest::find($request->id);
                    $parentid = $untag->from_id;
                    $userid = $untag->to_id;
                    $tag_parent = Tag_Parents::select('*')->where('user_id', $userid)->where('parent_id', $parentid)->first();
                    $tag_parent->delete();
                    if ($untag->delete()) {
                        return (json_encode(array('status' => 'success', 'message' => "Untag Successfully")));
                    }
                    return (json_encode(array('status' => 'error', 'message' => "Untagging not successfull")));
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
     * @created : Feb 28, 2019
     * @author  : Anup
     * @access  : public
     * @Purpose : This function is use to get level and semester data.
     * @params  : None
     * @return  : None
     */

    public function insight(Request $request) {
        try {
            $user = Auth::user();
            $limit = Helper::getRetakeTestLimit($user->id);
            /* $fast_score = Helper::getUserFastScore($user->id); */
            $sublevels = TestResult::getSublevels();
            if (!empty($sublevels)) {
                $first_sublevel = $sublevels[0]->id;
            }

            $getsemester = DB::table('semesters')->orderBy('priority', 'asc')->where('status', 1)->get()->toArray();
            $level_semester = DB::table('semesters')->orderBy('priority', 'asc')->where('status', 1)->where('sublevel_id', $first_sublevel)->get()->toArray();

            if (!empty($level_semester)) {
                $first_semester = $level_semester[0]->id;
            }
            $level = TestResult::getlevels();
            /* -- start level, sublevel and semester for the overview page --------- */
            $level_id = $user->level_id;
            $user_test_data = DB::table('user_level_data')->where('userId', $user->id)->first();
            if ($user_test_data) {
                if ($user_test_data->last_sem != null) {
                    $sem_id = DB::select("(SELECT fi_semesters.id FROM `fi_semesters` WHERE fi_semesters.sublevel_id = $user_test_data->current_sublevel AND fi_semesters.id > $user_test_data->last_sem ORDER BY priority DESC LIMIT 1) UNION (SELECT fi_semesters.id FROM fi_semesters WHERE fi_semesters.sublevel_id = (SELECT fi_sublevels.id FROM fi_sublevels WHERE fi_sublevels.id>$user_test_data->current_sublevel ORDER BY priority ASC LIMIT 1) ORDER BY fi_semesters.priority ASC LIMIT 1)");
                    if (!empty($sem_id)) {
                        $semester = Semester::join('sublevels', 'semesters.sublevel_id', '=', 'sublevels.id')->select('semesters.id as SemID', 'semesters.sem_name', 'semesters.sublevel_id', 'sublevels.sublevel_name', DB::raw("(select level_name from fi_levels where id = $level_id) as level_name"), DB::raw("(select id from fi_levels where id = $level_id) as levelid"))->where('semesters.status', '1')->where('semesters.id', $sem_id[0]->id)->get()->toArray();
                    }
                } else {
                    $semester = Semester::join('sublevels', 'semesters.sublevel_id', '=', 'sublevels.id')->select('semesters.id as SemID', 'semesters.sem_name', 'semesters.sublevel_id', 'sublevels.sublevel_name', DB::raw("(select level_name from fi_levels where id = $level_id) as level_name"), DB::raw("(select id from fi_levels where id = $level_id) as levelid"))->where('semesters.status', '1')->where('semesters.sublevel_id', $user_test_data->current_sublevel)->orderBy('semesters.priority', 'ASC')->limit(1)->get()->toArray();
                }
            }

            /* -- end level, sublevel and semester for the overview page --------- */
            //            $testresult = TestResult::select('test_results.id as test_id', 'test_results.*')->selectRaw("IFNULL((SELECT MAX(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id < test_id AND fi_test_results.user_id = $user->id),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id > test_id AND fi_test_results.user_id = $user->id),'') as prev_id")->where('user_id', $user->id)->orderBy('test_results.id', 'DESC')->first();
            $testresult = TestResult::select('test_results.id as test_id', 'test_results.*')->selectRaw("IFNULL((SELECT MAX(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id < test_id AND fi_test_results.user_id = $user->id AND fi_test_results.level_id = $user->level_id AND fi_test_results.sublevel_id = $first_sublevel AND fi_test_results.sem_id = $first_semester),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id > test_id AND fi_test_results.user_id = $user->id AND fi_test_results.level_id = $user->level_id AND fi_test_results.sublevel_id = $first_sublevel AND fi_test_results.sem_id = $first_semester),'') as prev_id")->where('user_id', $user->id)->where('level_id', $user->level_id)->where('sublevel_id', $first_sublevel)->where('sem_id', $first_semester)->orderBy('test_results.id', 'DESC')->first();
          
            if ($testresult) {
                $cat_result = json_decode($testresult->categories_result, true);
                if (!empty($cat_result)) {
                    foreach ($cat_result as $key => $value) {
                        $category_data = Category::select('category_name')->where('id', $value['category_id'])->first();
                        $cat_result[$key]['category_name'] = $category_data->category_name;
                    }
                }
            } else {
                $testresult = "";
                $cat_result = Category::where('level_id',$level_id)->get();
            }
            
            return view('front_end.insight', compact(['cat_result', 'testresult', 'limit', 'level', 'sublevels', 'user', 'semester', 'getsemester', 'level_semester']));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Feb 05, 2019
     * @author  : Anup
     * @access  : public
     * @Purpose : This function is used for the compare view.
     * @params  : None
     * @return  : None
     */

    public function compare(Request $request) {
        try {
            $user = Auth::user();
            $tagresult = Tag_Parents::where('request_mode', '2')->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                                ->orWhere('parent_id', $user->id);
                    })->get()->toArray();
            $friend_ids = array_unique(array_merge(array_column($tagresult, 'user_id'), array_column($tagresult, 'parent_id')));
            $user_rank = "1";
            $friend_result = array();
            if (!empty($friend_ids)) {
                DB::statement(DB::raw('set @rownumber=0'));
                $friend_result = new User();
                $friend_result = $friend_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'username', 'user_type', 'country_id', 'fast_score', DB::raw("(SELECT country_name FROM fi_countries WHERE fi_countries.id = country_id) as country_name"), 'id as user_id')->whereIn('id', $friend_ids);
                $friend_result = $friend_result->where('fast_score', '!=', '0')->orderBy('fast_score', 'DESC')->get()->toArray();
            } else {
                $friend_result = new User();
                $friend_result = $friend_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'username', 'user_type', 'country_id', 'fast_score', DB::raw("(SELECT country_name FROM fi_countries WHERE fi_countries.id = country_id) as country_name"), 'id as user_id')->where('id', $user->id);
                $friend_result = $friend_result->where('fast_score', '!=', '0')->orderBy('fast_score', 'DESC')->get()->toArray();
            }
            $country_result = array();
            $user_result = array();
            DB::statement(DB::raw('set @rownumber=0'));
            $country_wise_result = new User();
            $country_wise_result = $country_wise_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'username', 'user_type', 'country_id', 'fast_score', DB::raw("(SELECT country_name FROM fi_countries WHERE fi_countries.id = country_id) as country_name"), 'id as user_id')->where('country_id', $user->country_id)->where('user_type', $user->user_type);
            /* $country_wise_result = new CountryWiseScore();
              $country_wise_result = $country_wise_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'user_country_wise_score.*')->where('country_id', $user->country_id)->where('user_type', $user->user_type); */
            $country_wise_result = $country_wise_result->where('fast_score', '!=', '0')->orderBy('fast_score', 'DESC')->get()->toArray();
            if (!empty($country_wise_result)) {
                $result_data = array_column($country_wise_result, 'user_id');
                //print_r($result_data); die;
                if (in_array($user->id, $result_data)) {
                    $current_index = array_search($user->id, $result_data);
                    $user_rank = $country_wise_result[$current_index]['Rank'];
                    $country_result = array_slice($country_wise_result, 0, 9);
                } else {
                    $user_result = User::select(DB::raw("$user_rank as Rank"), 'username', 'fast_score', 'id as user_id')->where('fast_score', '!=', '0')->where('id', $user->id)->first();
                }
            } else {
                /* $user_result = DB::table('user_country_wise_score')->select(DB::raw("$user_rank as Rank"), 'username', 'fast_score')->where('fast_score','!=','0')->where('user_id', $user->id)->first(); */
                $user_result = User::select(DB::raw("$user_rank as Rank"), 'username', 'fast_score', 'id as user_id')->where('fast_score', '!=', '0')->where('id', $user->id)->first();
            }
            return view('front_end.compare', compact(['user_result', 'country_result', 'friend_result','images']));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            $err_result = $e->getMessage();
            return (json_encode(array('status' => 'error', 'message' => $err_result)));
        }
    }

    /*
     * @created : March 05, 2019
     * @author  : Anup
     * @access  : public
     * @Purpose : This function is used for the ranking details of user.
     * @params  : None
     * @return  : None
     */

    public function getUserRankData(Request $request) {
        try {
            $user = Auth::user();
            if ($user->user_type == '2') {
                $tagresult = Tag_Parents::where('parent_id', $user->id)->where('request_mode', '1')->get()->toArray();
            } else if ($user->user_type == '3') {
                $tagresult = Tag_Parents::where('parent_id', $user->id)->orwhere('user_id', $user->id)->where('request_mode', '2')->get()->toArray();
            }
            $child_id = array_column($tagresult, 'user_id');
            $current_child_id = $request->id;
            $data = array();
            $data['next_child_id'] = "";
            $data['prev_child_id'] = "";
            $data['country_result_child'] = array();
            $data['child_result'] = array();
            $data['child_name'] = "";
            if (!empty($child_id)) {
                $current_index = array_search($current_child_id, $child_id);
                if (array_key_exists($current_index, $child_id)) {
                    if (array_key_exists($current_index + 1, $child_id)) {
                        $data['next_child_id'] = $child_id[$current_index + 1];
                    }
                    if (array_key_exists($current_index - 1, $child_id)) {
                        $data['prev_child_id'] = $child_id[$current_index - 1];
                    }
                }
                $child_data = User::find($current_child_id);
                $data['child_name'] = $child_data->username;
                DB::statement(DB::raw('set @rownumber=0'));
                /* $country_child_result = new CountryWiseScore(); */
                $user_rank = "1";
                $country_child_result = new User();
                $country_child_result = $country_child_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'username', 'user_type', 'country_id', 'fast_score', DB::raw("(SELECT country_name FROM fi_countries WHERE fi_countries.id = country_id) as country_name"), 'id as user_id')->where('country_id', $child_data->country_id)->where('user_type', '3');
                /* $country_child_result = $country_child_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'user_country_wise_score.*')->where('country_id', $child_data->country_id)->where('user_type', '3'); */
                $country_child_result = $country_child_result->orderBy('fast_score', 'DESC')->get()->toArray();
                if (!empty($country_child_result)) {
                    $result_data = array_column($country_child_result, 'user_id');
                    //print_r($result_data); die;
                    if (in_array($child_data->id, $result_data)) {
                        $current_index = array_search($child_data->id, $result_data);
                        $user_rank = $country_child_result[$current_index]['Rank'];
                        unset($country_child_result[$current_index]);
                    }
                    $data['country_result_child'] = array_slice($country_child_result, 0, 9);
                }
                /* $data['child_result'] = CountryWiseScore::select(DB::raw("$user_rank as Rank"), 'username', 'fast_score')->where('user_id', $child_data->id)->first(); */
                $data['child_result'] = User::select(DB::raw("$user_rank as Rank"), 'username', 'fast_score')->where('id', $child_data->id)->first();
            }
            
            return (json_encode(array('status' => 'success', 'data' => $data)));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    public function parentGetUserRankData(Request $request) {
        try {
            $user = Auth::user();
            if ($user->user_type == '2') {
                $tagresult = Tag_Parents::where('parent_id', $user->id)->where('request_mode', '1')->get()->toArray();
            } else if ($user->user_type == '3') {
                $tagresult = Tag_Parents::where('parent_id', $user->id)->orwhere('user_id', $user->id)->where('request_mode', '2')->get()->toArray();
            }
            $child_id = array_column($tagresult, 'user_id');
            $current_child_id = $request->id;
            $data = array();
            $data['next_child_id'] = "";
            $data['prev_child_id'] = "";
            $data['country_result_child'] = array();
            $data['child_result'] = array();
            $data['child_name'] = "";
            if (!empty($child_id)) {
                $current_index = array_search($current_child_id, $child_id);
                if (array_key_exists($current_index, $child_id)) {
                    if (array_key_exists($current_index + 1, $child_id)) {
                        $data['next_child_id'] = $child_id[$current_index + 1];
                    }
                    if (array_key_exists($current_index - 1, $child_id)) {
                        $data['prev_child_id'] = $child_id[$current_index - 1];
                    }
                }
                $child_data = User::find($current_child_id);
                $data['child_name'] = $child_data->username;
                DB::statement(DB::raw('set @rownumber=0'));
                $country_child_result = new CountryWiseScore();
                $user_rank = "1";
                $country_child_result = $country_child_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'country_wise_score.*')->where('country_id', $child_data->country_id)->where('user_type', '3');
                $country_child_result = $country_child_result->orderBy('res_score', 'DESC')->get()->toArray();
                if (!empty($country_child_result)) {
                    $result_data = array_column($country_child_result, 'user_id');
                    //print_r($result_data); die;
                    if (in_array($child_data->id, $result_data)) {
                        $current_index = array_search($child_data->id, $result_data);
                        $user_rank = $country_child_result[$current_index]['Rank'];
                        unset($country_child_result[$current_index]);
                    }
                    $data['country_result_child'] = array_slice($country_child_result, 0, 9);
                }
                $data['child_result'] = CountryWiseScore::select(DB::raw("$user_rank as Rank"), 'username', 'res_score')->where('user_id', $child_data->id)->first();
            }
            return (json_encode(array('status' => 'success', 'data' => $data)));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    public function parentInsight(Request $request) {
        try {
            $user = Auth::user();
            $limit = Helper::getRetakeTestLimit($user->id);
            $testresult = ParentTestResult::select('parent_test_results.id as test_id', 'parent_test_results.*')->selectRaw("IFNULL((SELECT MAX(fi_parent_test_results.id) FROM fi_parent_test_results WHERE fi_parent_test_results.id < test_id AND fi_parent_test_results.user_id = $user->id),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_parent_test_results.id) FROM fi_parent_test_results WHERE fi_parent_test_results.id > test_id AND fi_parent_test_results.user_id = $user->id),'') as prev_id")->where('user_id', $user->id)->orderBy('parent_test_results.id', 'DESC')->first();
//            dd($testresult);
//            die;
            if ($testresult) {
                $cat_result = json_decode($testresult->categories_result, true);
                if (!empty($cat_result)) {
                    foreach ($cat_result as $key => $value) {
                        $category_data = ParentCategory::select('category_name')->where('id', $value['category_id'])->first();
                        $cat_result[$key]['category_name'] = $category_data->category_name;
                    }
                }
            } else {
                $testresult = "";
                $cat_result = DB::table('parent_categories')->get()->toArray();
            }
             
            return view('parent.insight', compact(['cat_result', 'testresult', 'limit','images']));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    public function parentCompare(Request $request) {
        try {
            $user = Auth::user();
            $tagresult = Tag_Parents::where('request_mode', '2')->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                                ->orWhere('parent_id', $user->id);
                    })->get()->toArray();
            $friend_ids = array_unique(array_merge(array_column($tagresult, 'user_id'), array_column($tagresult, 'parent_id')));
            $user_rank = "1";
            $friend_result = array();
            if (!empty($friend_ids)) {
                DB::statement(DB::raw('set @rownumber=0'));
                $friend_result = new CountryWiseScore();
                $friend_result = $friend_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'country_wise_score.*')->whereIn('user_id', $friend_ids);
                $friend_result = $friend_result->orderBy('res_score', 'DESC')->get()->toArray();
            } else {
                $friend_result = new CountryWiseScore();
                $friend_result = $friend_result::select(DB::raw("$user_rank as Rank"), 'country_wise_score.*')->where('user_id', $user->id);
                $friend_result = $friend_result->orderBy('res_score', 'DESC')->get()->toArray();
            }
            $country_result = array();
            $user_result = array();
            DB::statement(DB::raw('set @rownumber=0'));
            $country_wise_result = new CountryWiseScore();
            $country_wise_result = $country_wise_result::select(DB::raw('@rownumber:=@rownumber+1 as Rank'), 'country_wise_score.*')->where('country_id', $user->country_id)->where('user_type', $user->user_type);
            $country_wise_result = $country_wise_result->orderBy('res_score', 'DESC')->get()->toArray();
            if (!empty($country_wise_result)) {
                $result_data = array_column($country_wise_result, 'user_id');
                //print_r($result_data); die;
                if (in_array($user->id, $result_data)) {
                    $current_index = array_search($user->id, $result_data);
                    $user_rank = $country_wise_result[$current_index]['Rank'];
                    $country_result = array_slice($country_wise_result, 0, 9);
                } else {
                    $user_result = DB::table('country_wise_score')->select(DB::raw("$user_rank as Rank"), 'username', 'res_score')->where('user_id', $user->id)->first();
                }
            } else {
                $user_result = DB::table('country_wise_score')->select(DB::raw("$user_rank as Rank"), 'username', 'res_score')->where('user_id', $user->id)->first();
            }
             
            return view('parent.compare', compact(['user_result', 'country_result', 'friend_result']));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            $err_result = $e->getMessage();
            return (json_encode(array('status' => 'error', 'message' => $err_result)));
        }
    }

    /*
     * @created : Feb 02, 2019
     * @author  : Anup
     * @access  : public
     * @Purpose : This function is use to send request for retest.
     * @params  : None
     * @return  : None
     */

    public function sendTestRequest(Request $request) {
        try {
            $rules = array(
                'id' => 'required|numeric',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = "";
                if (isset($failedRules['id']))
                    $errorMsg = $failedRules['id'][0] . "\n";
                return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
            } else {
                $auth = Auth::user();
                $user = User::where('id', $request->id)->first();
                if ($user) {
                    DB::table('user_notification')->insert(['from_id' => $auth->id, 'to_id' => $user->id, 'message' => "$auth->username requested you to re-take the fast test for better score."]);

                    if ($user->email != '') {
                        Notification::send(User::find($request->id), new TestRequest($request->id));
                    }
                    return (json_encode(array('status' => 'success', 'message' => "Request send to user successfully")));
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

    /* @created : Feb 25, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get Sublevels.
     * @params  : none
     * @return  : none
     */

    public function getLevel(Request $request) {
        if ($request->ajax()) {
            try {
                $user = Auth::user();
                $result = User::find($user->id);
                $result->level_id = $request->id;
                if ($result->save()) {
                    return (json_encode(array('status' => 'success', 'message' => sprintf('Change level successfully'))));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to update level'))));
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

    /* @created : 27 March 2019
     * @author  : Nadeem
     * Purpose : This function is used to save instructor image according to user 
     */

    public function InstructorImageUpdate(Request $request) {
        if ($request->ajax()) {
            try {
                if ($request->image) {
                    $user = Auth::user();
                    $data = explode('/storage/', $request->image);
                    $user->instructor_avatar = $data[1];
                    if ($user->save()) {
                        return (json_encode(array('status' => 'success', 'message' => sprintf('Update intstructor image  successfully.'))));
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to update user intstructor image.'))));
                    }
                } else {
                    return (json_encode(array('status' => 'error', 'message' => sprintf('Please select any intstructor image.'))));
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
     * @created : March 29, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get Semester.
     * @params  : none
     * @return  : none
     */

    public function getSemester(Request $request) {
        if ($request->ajax()) {
            try {
                $semester = Semester::where('sublevel_id', $request->sublevelid)->where('status', 1)->get()->toArray();
                if ($semester) {
                    return (json_encode(array('status' => 'success', 'data' => $semester)));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => "Please select level")));
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
     * @created : April 02, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is used to get result according to the sublevel and semester.
     * @params  : none
     * @return  : none
     */

    public function getSublevelSemresult(Request $request) {
        try {
            $user = Auth::user();
            $data['testresult'] = $testresult = TestResult::select('test_results.id as test_id', 'test_results.*')->selectRaw("IFNULL((SELECT MAX(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id < test_id AND fi_test_results.user_id = $user->id AND fi_test_results.level_id = $user->level_id AND fi_test_results.sublevel_id = $request->sublevelid AND fi_test_results.sem_id = $request->semesterid),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id > test_id AND fi_test_results.user_id = $user->id AND fi_test_results.level_id = $user->level_id AND fi_test_results.sublevel_id = $request->sublevelid AND fi_test_results.sem_id = $request->semesterid),'') as prev_id")->where('user_id', $user->id)->where('level_id', $user->level_id)->where('sublevel_id', $request->sublevelid)->where('sem_id', $request->semesterid)->orderBy('test_results.id', 'DESC')->first();
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
            } else {
                $data['testresult'] = "";
                $cat_result = DB::table('categories')->get()->toArray();
                $data['category_result'] = $cat_result;
//                print_r($data['category_result']['0']->category_name);die;
                return (json_encode(array('status' => 'error', 'data' => $data)));
                // return (json_encode(array('status' => 'error', 'message' => "No result found, please choose another sublevel and semester.")));
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
