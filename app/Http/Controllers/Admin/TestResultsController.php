<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Model\TestResult;
use App\Model\ParentTestResult;
use App\Model\Category;
use App\Model\ParentCategory;
use App\Model\Questions;
use App\Model\ParentQuestions;
use App\Model\Settings;
use App\Helpers\Helper;
use App\Model\Semester;
use Exception;


class TestResultsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //    public function __construct() {
    //        $this->middleware('auth');
    //    }

    /*
     * @created : January 12, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to view page for the taketest.
     * @params  : None
     * @return  : None
     */

    public function test_view(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $user_type = Auth::user()->user_type;
            $country_id = Auth::user()->country_id;
            $categories = Category::select('id')->where('status', 1)->where('level_id', $request->level_id)->get()->toArray();
//            $categories = Category::select('id')->where('status', 1)->get()->toArray();
            $questions = array();
//            dd($categories);
            if (!empty($categories)) {
                $question_limit = Settings::select('settings_json')->where('user_id', '1')->first();
                if (!empty($question_limit)) {
                    $limit = json_decode($question_limit['settings_json'], true);
                    $cate_ques = $limit['category_wise_question_limit'];
                    if ($cate_ques != 0) {
                        $cate_ques_limit = $limit['category_wise_question_limit'];
                    } else {
                        $cate_ques_limit = 5;
                    }
                } else {
                    $cate_ques_limit = 5;
                }
                $i = 0;
                foreach ($categories as $index => $cat_id) {
                    if ($i == 0) {
                        $questions = Questions::orderBy(DB::raw('RAND()'))->where('category_id', $cat_id['id'])->whereRaw("find_in_set($country_id,country_id)")->where('level_id', $request->level_id)->where('sublevel_id', $request->sublevel_id)->where('semester_id', $request->sem_id)->where('user_type', $user_type)->join('answers', 'questions.id', '=', 'answers.question_id')->select('questions.id as question_id','questions.category_id','questions.level_id','questions.sublevel_id','questions.semester_id','questions.question_name','questions.question_type','questions.file_attached','answers.id as answer_id','answers.options')->selectRaw('GROUP_CONCAT(options SEPARATOR "_^@") as options')->take($cate_ques_limit)->groupBy('question_id');
                        
                        } else if ($i !== 0) {
                        $questions1[$i] = Questions::orderBy(DB::raw('RAND()'))->where('category_id', $cat_id['id'])->whereRaw("find_in_set($country_id,country_id)")->where('level_id', $request->level_id)->where('sublevel_id', $request->sublevel_id)->where('semester_id', $request->sem_id)->where('user_type', $user_type)->join('answers', 'questions.id', '=', 'answers.question_id')->select('questions.id as question_id','questions.category_id','questions.level_id','questions.sublevel_id','questions.semester_id','questions.question_name','questions.question_type','questions.file_attached','answers.id as answer_id','answers.options')->selectRaw('GROUP_CONCAT(options SEPARATOR "_^@") as options')->take($cate_ques_limit)->groupBy('question_id');
                        $questions = $questions->union($questions1[$i]);
                    }
                    $i++;
                }
                $questions = $questions->orderBy('category_id', 'ASC')->get();
            }
            return view('test.taketest', compact('questions'));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : April 06, 2019
     * @author  : Anup
     * @access  : public
     * @Purpose : This function is use to view page for the parent taketest.
     * @params  : None
     * @return  : None
     */

    public function parent_test_view(Request $request)
    {
        $id = Auth::user()->id;
        $country_id = Auth::user()->country_id;
        $categories = ParentCategory::select('id')->where('status', 1)->get()->toArray();
        $question_limit = Settings::select('settings_json')->where('user_id', '1')->first();
        if (!empty($question_limit)) {
            $limit = json_decode($question_limit['settings_json'], true);
            $cate_ques = $limit['category_wise_question_limit'];
            if ($cate_ques != 0) {
                $cate_ques_limit = $limit['category_wise_question_limit'];
            } else {
                $cate_ques_limit = 5;
            }
        } else {
            $cate_ques_limit = 5;
        }
        $i = 0;
        foreach ($categories as $index => $cat_id) {
            if ($i == 0) {
                $questions = ParentQuestions::orderBy(DB::raw('RAND()'))->where('category_id', $cat_id['id'])->whereRaw("find_in_set($country_id,country_id)")
                    ->join('parent_answers', 'parent_questions.id', '=', 'parent_answers.question_id')->select('parent_questions.id as question_id','parent_questions.category_id','parent_questions.question_name','parent_questions.question_type','parent_questions.file_attached','parent_answers.id as answer_id','parent_answers.options')->selectRaw('GROUP_CONCAT(options SEPARATOR "_^@") as options')->take($cate_ques_limit)->groupBy('question_id');
            } else if ($i !== 0) {
                $questions1[$i] = ParentQuestions::orderBy(DB::raw('RAND()'))->where('category_id', $cat_id['id'])->whereRaw("find_in_set($country_id,country_id )")
                        ->join('parent_answers', 'parent_questions.id', '=', 'parent_answers.question_id')->select('parent_questions.id as question_id','parent_questions.category_id','parent_questions.question_name','parent_questions.question_type','parent_questions.file_attached','parent_answers.id as answer_id','parent_answers.options')->selectRaw('GROUP_CONCAT(options SEPARATOR "_^@") as options')->take($cate_ques_limit)->groupBy('question_id');
                $questions = $questions->union($questions1[$i]);
            }
            $i++;
        }
        $questions = $questions->orderBy('category_id', 'ASC')->get();
//        print_r($questions); die;
        return view('parent_test.taketest', compact('questions'));
    }

    /*
     * @created : January 16, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to view page for the result.
     * @params  : None
     * @return  : None
     */

    public function getresult(request $request)
    {
        try {
            $correct_ans = $request->correct_ans;
            $score = $request->score;
            return view('test.complete_test', compact('correct_ans', 'score'));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : January 16, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to save test result.
     * @params  : None
     * @return  : None
     */

    public function CalculateResultData(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $mdata = $request->all();
            $total_questions = count($mdata['responses']);
            $test_duration = $mdata['quiz_duration'];
            $level_id = $mdata['level_id'];
            $sublevel_id = $mdata['sublevel_id'];
            $semester_id = $mdata['semester_id'];
            $i = 0;
            $all = array();
            $ans_json = array();
            $cat = array();
            $catwise_scores = array();
            $score = 0;
            foreach ($mdata['responses'] as $quest_data) {
                $question_type = TestResult::GetQuestionType($quest_data['questionId']);
                if ($question_type->question_type == '1') {
                    $result = TestResult::GetFillAnswer($quest_data['questionId']);
                    if (!in_array($result->category_id, $cat)) {
                        array_push($cat, $result->category_id);
                    }
                    $ans_json[$i]['category_id'] = $result->category_id;
                    $ans_json[$i]['question_id'] = $quest_data['questionId'];
                    $ans_json[$i]['given_options'] = $quest_data['given_answer'];
                    $ans_json[$i]['correct_options'] = $result->correct_options;
                    $correct_options = $result->correct_options;
                    $given_answer = $quest_data['given_answer'];
                    $catwise_scores[$result->category_id]['category_score'] = isset($catwise_scores[$result->category_id]['category_score']) ? $catwise_scores[$result->category_id]['category_score'] : 0;
                    $catwise_scores[$result->category_id]['total_question'] = isset($catwise_scores[$result->category_id]['total_question']) ? $catwise_scores[$result->category_id]['total_question'] + 1 : 1;
                    if (strtoupper($correct_options) == strtoupper($given_answer)) {
                        $ans_json[$i]['correct_count'] = true;
                        $score++;
                        $catwise_scores[$result->category_id]['category_score'] = isset($catwise_scores[$result->category_id]['category_score']) ? $catwise_scores[$result->category_id]['category_score'] + 1 : 1;
                    }
                } elseif ($question_type->question_type == '2') {
                    $correct_array = array();

                    $result = TestResult::GetMultiAnswer($quest_data['questionId']);

                    $k = 0;
                    foreach ($result as $options) {
                        $correct_array[$k] = $options->options;
                        $category_id = $options->category_id;
                        $k++;
                    }
                    if (!in_array($category_id, $cat)) {
                        array_push($cat, $category_id);
                    }
                    $ans_json[$i]['category_id'] = $category_id;
                    $ans_json[$i]['question_id'] = $quest_data['questionId'];
                    $ans_json[$i]['given_options'] = (!empty($quest_data['given_answer'])) ? $quest_data['given_answer'] : "";
                    $ans_json[$i]['correct_options'] = $correct_array;
                    $catwise_scores[$category_id]['category_score'] = isset($catwise_scores[$category_id]['category_score']) ? $catwise_scores[$category_id]['category_score'] : 0;
                    $catwise_scores[$category_id]['total_question'] = isset($catwise_scores[$category_id]['total_question']) ? $catwise_scores[$category_id]['total_question'] + 1 : 1;
                    if (!empty($quest_data['given_answer'])) {
                        $result_array = array_diff($quest_data['given_answer'], $correct_array);
                        if (empty($result_array)) {
                            $ans_json[$i]['correct_count'] = true;
                            $score++;
                            $catwise_scores[$category_id]['category_score'] = isset($catwise_scores[$category_id]['category_score']) ? $catwise_scores[$category_id]['category_score'] + 1 : 1;
                        }
                    }
                } elseif ($question_type->question_type == '3') {
                    $correct_array = array();
                    $result = TestResult::GetArrangeAnswer($quest_data['questionId']);
                    $j = 0;
                    foreach ($result as $options) {
                        $correct_array[$j] = $options->correct_options;
                        $category_id = $options->category_id;
                        $j++;
                    }
                    if (!in_array($category_id, $cat)) {
                        array_push($cat, $category_id);
                    }
                    $ans_json[$i]['category_id'] = $category_id;
                    $ans_json[$i]['question_id'] = $quest_data['questionId'];
                    $ans_json[$i]['given_options'] = $quest_data['given_answer'];
                    $ans_json[$i]['correct_options'] = $correct_array;
                    $result_array = array_intersect_assoc($correct_array, $quest_data['given_answer']);
                    $count = count($result_array);
                    $catwise_scores[$category_id]['category_score'] = isset($catwise_scores[$category_id]['category_score']) ? $catwise_scores[$category_id]['category_score'] : 0;
                    $catwise_scores[$category_id]['total_question'] = isset($catwise_scores[$category_id]['total_question']) ? $catwise_scores[$category_id]['total_question'] + 1 : 1;
                    if ($count == '4') {
                        $score++;
                        $ans_json[$i]['correct_count'] = true;
                        $catwise_scores[$category_id]['category_score'] = isset($catwise_scores[$category_id]['category_score']) ? $catwise_scores[$category_id]['category_score'] + 1 : 1;
                    }
                }
                $i++;
            }
            $score_perc = round($score * 100 / $total_questions);
            $categories_result = array();
            $i = 0;
            foreach ($catwise_scores as $index => $vals) {
                $cat_score = round($vals['category_score'] * 100 / $vals['total_question']);
                $interpretation = TestResult::getInterpretationByScore($index, $cat_score);

                if ($interpretation) {
                    $categories_result[$i]['category_id'] = $index;
                    $categories_result[$i]['score'] = $cat_score;
                    $categories_result[$i]['interpretation'] = $interpretation['rand_int'];
                    $categories_result[$i]['range_id'] = $interpretation['range_id'];
                }
                $i++;
            }

            $category_data = Category::select('id')->where('level_id', $level_id)->get();
            foreach ($category_data as $category_data) {
                if (!array_key_exists($category_data->id, $catwise_scores)) {
                    $categories_result[$i]['category_id'] = $category_data->id;
                    $categories_result[$i]['score'] = "0";
                    $categories_result[$i]['interpretation'] = "";
                    $categories_result[$i]['range_id'] = "";
                    $i++;
                }
            }
            /* $answer = new TestResult();
              $ov_inter = TestResult::getOverAllInterpretationByScore($categories_result, $score_perc);
              if ($ov_inter != false) {
              $ov_int = array_random(json_decode($ov_inter['interpretation'], true));
              $answer->overall_interpretation = $ov_int;
              $answer->long_summary = $ov_inter['summary'];
              } else {
              $answer->overall_interpretation = "";
              $answer->long_summary = "";
              } */
            $answer = new TestResult();
            $ov_inter = TestResult::getOverAllInterpretationByScore($categories_result, $score_perc);

            if ($ov_inter != false) {
                if (isset($ov_inter['interpretation'])) {
                    $ov_int = array_random(json_decode($ov_inter['interpretation'], true));
                    $answer->overall_interpretation = $ov_int;
                } else {
                    $answer->overall_interpretation = "";
                }
            } else {
                $answer->overall_interpretation = "";
            }

            $answer->user_id = $id;
            $answer->level_id = $level_id;
            $answer->sublevel_id = $sublevel_id;
            $answer->sem_id = $semester_id;
            $answer->score = $score_perc;
            $answer->answer = json_encode($ans_json);
            $answer->categories_result = json_encode($categories_result);
            $answer->duration = $test_duration;
            if ($answer->save()) {
                return (json_encode(array('status' => 'success', 'score' => $score_perc, 'correct_answer' => $score, 'total_questions' => $total_questions)));
            } else {
                return (json_encode(array('status' => 'error', 'message' => 'Failed to save result')));
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
     * @created : Feb 26, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get the levels of users.
     * @params  : None
     * @return  : None
     */

    public function GetLevelData(request $request)
    {
        if ($request->ajax()) {
            try {
                $user = Auth::user();
                $level_id = $user->level_id;
                $sublevel_id = $request->sublevel_id;
                $test_type = $request->test_type;
                if ($request->level_id) {
                    $level_id = $request->level_id;
                }

                if ($test_type == '1') {
                    $semester = array();
                    $user_test_data = DB::table('user_level_data')->where('userId', $user->id)->first();
                    if ($user_test_data) {
                        if ($user_test_data->last_sem != null) {
                            $sem_id = DB::select("(SELECT fi_semesters.id FROM `fi_semesters` WHERE fi_semesters.sublevel_id = $user_test_data->current_sublevel AND fi_semesters.id > $user_test_data->last_sem ORDER BY priority DESC LIMIT 1) UNION (SELECT fi_semesters.id FROM fi_semesters WHERE fi_semesters.sublevel_id = (SELECT fi_sublevels.id FROM fi_sublevels WHERE fi_sublevels.id>$user_test_data->current_sublevel ORDER BY priority ASC LIMIT 1) ORDER BY fi_semesters.priority ASC LIMIT 1)
                            ");
                            //print_r($sem_id); die;
                            if (!empty($sem_id)) {
                                $semester = Semester::join('sublevels', 'semesters.sublevel_id', '=', 'sublevels.id')->select('semesters.id as SemID', 'semesters.sem_name', 'semesters.sublevel_id', 'sublevels.sublevel_name', DB::raw("(select level_name from fi_levels where id = $level_id) as level_name"), DB::raw("(select id from fi_levels where id = $level_id) as levelid"))->where('semesters.status', '1')->where('semesters.id', $sem_id[0]->id)->get()->toArray();
                            }
                        } else {
                            $semester = Semester::join('sublevels', 'semesters.sublevel_id', '=', 'sublevels.id')->select('semesters.id as SemID', 'semesters.sem_name', 'semesters.sublevel_id', 'sublevels.sublevel_name', DB::raw("(select level_name from fi_levels where id = $level_id) as level_name"), DB::raw("(select id from fi_levels where id = $level_id) as levelid"))->where('semesters.status', '1')->where('semesters.sublevel_id', $user_test_data->current_sublevel)->orderBy('semesters.priority', 'ASC')->limit(1)->get()->toArray();
                        }
                    }
                } else {
                    $semester = Semester::select('id as SemID', 'sublevel_id', 'sem_name', DB::raw("$level_id as level_id"))->selectRaw("IFNULL((SELECT test_score from fi_user_fast_score where user_id = $user->id AND level_id = $level_id AND sublevel_id = $sublevel_id AND sem_id = fi_semesters.id),'0') as score")->selectRaw("IF(EXISTS(SELECT * FROM fi_test_results WHERE fi_test_results.user_id = $user->id AND fi_test_results.level_id = $level_id AND fi_test_results.sublevel_id = $sublevel_id AND fi_test_results.sem_id = fi_semesters.id),'1','2') as test_status")->where('sublevel_id', $sublevel_id)->where('status', '1')->get()->toArray();
                    if (empty($semester)) {
                        $semester = array();
                    }
                    return (json_encode(array('status' => 'success', 'data' => $semester)));
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
     * @created : January 16, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to save test result.
     * @params  : None
     * @return  : None
     */

    public function ParentCalculateResultData(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $mdata = $request->all();
//            $data = json_encode($mdata);
//            $data  ='{"quiz_duration":"00:01:46.28","auth_id":"2","responses":[{"questionId":"71","given_answer":["Difficulty in finding a person who wants to buy what you have and sell what you want."]},{"questionId":"9","given_answer":["Fall"]},{"questionId":"99","given_answer":["Identity theft"]},{"questionId":"38","given_answer":["It is not compulsory for a company to pay Dividends on its shares annually."]},{"questionId":"80","given_answer":["350"]},{"questionId":"22","given_answer":["It is best to use personal savings as much as possible to reduce the loan amount."]},{"questionId":"83","given_answer":["Loan him only a part of your savings that you can afford if it is for an emergency."]},{"questionId":"23","given_answer":["Cash, because he can never overspend."]},{"questionId":"69","given_answer":["Select one from a reputable company that covers the most number of diseases and illnesses at an affordable cost\/premium."]},{"questionId":"89","given_answer":["Whether or not the investment supports ones financial goals."]},{"questionId":"109","given_answer":["Compare the costs and quality of your friend\u2019s bicycle with other bicycles before buying one."]},{"questionId":"110","given_answer":["Buy a good smartphone within your budget."]},{"questionId":"115","given_answer":["Let the smartwatch craze pass because you don\u2019t really need it."]},{"questionId":"101","given_answer":["Use cash for small amounts and credit cards for larger amounts and pay the entire credit card bill on time."]},{"questionId":"105","given_answer":["Spend all her income because there is no need to plan for spending such a small amount."]}]}';
//          
//            $mdata =json_decode($data,true);
            
            $total_questions = count($mdata['responses']);
            $test_duration = $mdata['quiz_duration'];
            $i = 0;
            $all = array();
            $ans_json = array();
            $cat = array();
            $catwise_scores = array();
            $score = 0;
            foreach ($mdata['responses'] as $quest_data) {
                $question_type = ParentTestResult::GetQuestionType($quest_data['questionId']);
                if ($question_type->question_type == '1') {
                    $result = ParentTestResult::GetFillAnswer($quest_data['questionId']);
                    if (!in_array($result->category_id, $cat)) {
                        array_push($cat, $result->category_id);
                    }
                    $ans_json[$i]['category_id'] = $result->category_id;
                    $ans_json[$i]['question_id'] = $quest_data['questionId'];
                    $ans_json[$i]['given_options'] = $quest_data['given_answer'];
                    $ans_json[$i]['correct_options'] = $result->correct_options;
                    $correct_options = $result->correct_options;
                    $given_answer = $quest_data['given_answer'];
                    $catwise_scores[$result->category_id]['category_score'] = isset($catwise_scores[$result->category_id]['category_score']) ? $catwise_scores[$result->category_id]['category_score'] : 0;
                    $catwise_scores[$result->category_id]['total_question'] = isset($catwise_scores[$result->category_id]['total_question']) ? $catwise_scores[$result->category_id]['total_question'] + 1 : 1;
                    if (strtoupper($correct_options) == strtoupper($given_answer)) {
                        $ans_json[$i]['correct_count'] = true;
                        $score++;
                        $catwise_scores[$result->category_id]['category_score'] = isset($catwise_scores[$result->category_id]['category_score']) ? $catwise_scores[$result->category_id]['category_score'] + 1 : 1;
                    }
                } elseif ($question_type->question_type == '2') {
                    $correct_array = array();
                    $result = ParentTestResult::GetMultiAnswer($quest_data['questionId']);
                    $k = 0;
                    foreach ($result as $options) {
                        $correct_array[$k] = $options->options;
                        $category_id = $options->category_id;
                        $k++;
                    }
                    if (!in_array($category_id, $cat)) {
                        array_push($cat, $category_id);
                    }
                    $ans_json[$i]['category_id'] = $category_id;
                    $ans_json[$i]['question_id'] = $quest_data['questionId'];
                    $ans_json[$i]['given_options'] = (!empty($quest_data['given_answer'])) ? $quest_data['given_answer'] : "";
                    $ans_json[$i]['correct_options'] = $correct_array;
                    $catwise_scores[$category_id]['category_score'] = isset($catwise_scores[$category_id]['category_score']) ? $catwise_scores[$category_id]['category_score'] : 0;
                    $catwise_scores[$category_id]['total_question'] = isset($catwise_scores[$category_id]['total_question']) ? $catwise_scores[$category_id]['total_question'] + 1 : 1;
                    if (!empty($quest_data['given_answer'])) {
                        $result_array = array_diff($quest_data['given_answer'], $correct_array);
                        if (empty($result_array)) {
                            $ans_json[$i]['correct_count'] = true;
                            $score++;
                            $catwise_scores[$category_id]['category_score'] = isset($catwise_scores[$category_id]['category_score']) ? $catwise_scores[$category_id]['category_score'] + 1 : 1;
                        }
                    }
                } elseif ($question_type->question_type == '3') {
                    $correct_array = array();
                    $result = ParentTestResult::GetArrangeAnswer($quest_data['questionId']);
                    $j = 0;
                    foreach ($result as $options) {
                        $correct_array[$j] = $options->correct_options;
                        $category_id = $options->category_id;
                        $j++;
                    }
                    if (!in_array($category_id, $cat)) {
                        array_push($cat, $category_id);
                    }
                    $ans_json[$i]['category_id'] = $category_id;
                    $ans_json[$i]['question_id'] = $quest_data['questionId'];
                    $ans_json[$i]['given_options'] = $quest_data['given_answer'];
                    $ans_json[$i]['correct_options'] = $correct_array;
                    $result_array = array_intersect_assoc($correct_array, $quest_data['given_answer']);
                    $count = count($result_array);
                    $catwise_scores[$category_id]['category_score'] = isset($catwise_scores[$category_id]['category_score']) ? $catwise_scores[$category_id]['category_score'] : 0;
                    $catwise_scores[$category_id]['total_question'] = isset($catwise_scores[$category_id]['total_question']) ? $catwise_scores[$category_id]['total_question'] + 1 : 1;
                    if ($count == '4') {
                        $score++;
                        $ans_json[$i]['correct_count'] = true;
                        $catwise_scores[$category_id]['category_score'] = isset($catwise_scores[$category_id]['category_score']) ? $catwise_scores[$category_id]['category_score'] + 1 : 1;
                    }
                }
                $i++;
            }
            $score_perc = round($score * 100 / $total_questions);
            $categories_result = array();
            $i = 0;
            foreach ($catwise_scores as $index => $vals) {
                $cat_score = round($vals['category_score'] * 100 / $vals['total_question']);
                $interpretation = ParentTestResult::getInterpretationByScore($index, $cat_score);
                if ($interpretation) {
                    $categories_result[$i]['category_id'] = $index;
                    $categories_result[$i]['score'] = $cat_score;
                    $categories_result[$i]['interpretation'] = $interpretation['rand_int'];
                    $categories_result[$i]['range_id'] = $interpretation['range_id'];
                }
                $i++;
            }
             $category_data = ParentCategory::select('id')->get();
            foreach ($category_data as $category_data) {
                if (!array_key_exists($category_data->id, $catwise_scores)) {
                    $categories_result[$i]['category_id'] = $category_data->id;
                    $categories_result[$i]['score'] = "0";
                    $categories_result[$i]['interpretation'] = "";
                    $categories_result[$i]['range_id'] = "";
                    $i++;
                }
            }
            $answer = new ParentTestResult();
            $ov_inter = ParentTestResult::getOverAllInterpretationByScore($categories_result, $score_perc);
            if ($ov_inter != false) {
                $ov_int = array_random(json_decode($ov_inter['interpretation'], true));
                $answer->overall_interpretation = $ov_int;
//                $answer->long_summary = $ov_inter['summary'];
            } else {
                $answer->overall_interpretation = "";
//                $answer->long_summary = "";
            }
            $answer->user_id = $id;
            $answer->score = $score_perc;
            $answer->answer = json_encode($ans_json);
            $answer->categories_result = json_encode($categories_result);
            $answer->duration = $test_duration;
            if ($answer->save()) {
                return (json_encode(array('status' => 'success', 'score' => $score_perc, 'correct_answer' => $score, 'total_questions' => $total_questions)));
            } else {
                return (json_encode(array('status' => 'error', 'message' => 'Failed to save result')));
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
