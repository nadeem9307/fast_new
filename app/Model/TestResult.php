<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use App\User;
use Carbon;

class TestResult extends Model {
    /*
      |--------------------------------------------------------------------------
      | TestResult Model
      |--------------------------------------------------------------------------
      |
      | Here is we can make a function for overview, insight and child page
      | layout score.

     */

    public $table = "test_results";

    /*
     * @created : Jan 28, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get Interpretation.
     * @params  : none
     * @return  : Interpretation data random
     */

    public static function getInterpretationByScore($cat_id, $cat_score) {
        $rand_int = "";
        $range_id = "";
        if (($cat_id !== '') && ($cat_score !== '')) {
            $interpretation = OverAllRange::where('min_range', '<=', $cat_score);
            if ($cat_score == 100) {
                $interpretation = $interpretation->where('max_range', '>=', $cat_score);
            } else {
                $interpretation = $interpretation->where('max_range', '>', $cat_score);
            }
            $interpretation = $interpretation->select('id')->first();
            if ($interpretation) {
                $interpretations = Interpretation::where('category_id', $cat_id)->where('range_id', $interpretation->id)
                                ->select('interpretation')->first();
                $range_id = $interpretation->id;
                if ($interpretations) {
                    $rand_int = array_random(json_decode($interpretations->interpretation, true));
                }
            }
        }
        return compact('rand_int', 'range_id');
    }

    /*
     * @created : Jan 28, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get overall Interpretation.
     * @params  : none
     * @return  : overall Interpretation data random
     */

    public static function getOverAllInterpretationByScore($category_results = array(), $score_perc = 0) {

        $id = OverAllRange::where('min_range', '<=', $score_perc);
        if ($score_perc == 100) {
            $id = $id->where('max_range', '>=', $score_perc);
        } else {
            $id = $id->where('max_range', '>', $score_perc);
        }
        $id = $id->select('id')->first();
        if ($id) {
            $cate_ids = implode(",", array_column($category_results, 'category_id'));
            $inds_ids = implode(",", array_column($category_results, 'range_id'));
            $overall = OverAllInterpretation::where('category_ids', $cate_ids)->where('individual_range_ids', $inds_ids)->where('overall_range', $id->id)
                            ->select('interpretation')->first();
            if ($overall) {

                return $overall;
            }
            return false;
        }
    }

    /*
     * @created : Jan 28, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get question type and correct option for fill in the blank.
     * @params  : none
     * @return  : question type and correct option.
     */

    public static function GetFillAnswer($question_id) {

        $result = DB::table('questions')
                ->join('answers', 'questions.id', '=', 'answers.question_id')
                ->select('questions.category_id', 'answers.correct_options')
                ->where('questions.id', $question_id)
                ->first();

        return $result;
    }

    /*
     * @created : Jan 29, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get question type and correct option for Arrange order questions.
     * @params  : none
     * @return  : question type and correct option.
     */

    public static function GetArrangeAnswer($question_id) {

        $result = DB::table('questions')
                        ->join('answers', 'questions.id', '=', 'answers.question_id')
                        ->select('questions.category_id', 'answers.correct_options')
                        ->where('question_id', $question_id)->get()->toArray();

        return $result;
    }

    /*
     * @created : Jan 29, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get question type and correct option for multi option question.
     * @params  : none
     * @return  : question type and correct option.
     */

    public static function GetMultiAnswer($question_id) {

        $result = DB::table('questions')
                        ->join('answers', 'questions.id', '=', 'answers.question_id')
                        ->select('questions.category_id', 'answers.options')
                        ->where('answers.question_id', $question_id)
                        ->where('answers.correct_options', '1')
                        ->get()->toArray();


        return $result;
    }

    /*
     * @created : Jan 29, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get question type .
     * @params  : none
     * @return  : question type.
     */

    public static function GetQuestionType($question_id) {
        $result = DB::table('questions')
                        ->select('question_type')
                        ->where('id', $question_id)->first();
        return $result;
    }

    /*
     * @created : January 27, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view index page of overview.
     * @params  : None
     * @return  : None
     */

    public static function overviewlayout($request, $id, $fast_score) {

        $testresult = DB::table('test_results')->where('user_id', $id)->orderBy('id', 'DESC')->first();

        if (!empty($testresult)) {

            $cat_result = json_decode($testresult->categories_result, true);

            foreach ($cat_result as $index => $cat_results) {
                $catname = Category::where('id', $cat_results['category_id'])->select('category_name')->first();

                $cat_result[$index]['category_name'] = $catname->category_name;
            }
//          dd($cat_result);
            $summary = OverAllRange::where('min_range', '<=', $fast_score)->where('max_range', '>', $fast_score)->orwhere('max_range', '=', $fast_score)->select('summary')->first();

            return compact('testresult', 'cat_result', 'summary');
        }
    }

    /*
     * @created : January 27, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view page of parent and child insight.
     * @params  : None
     * @return  : None
     */

    public static function insightlayout($request) {
        $id = Auth::user()->id;
        $insightresult = DB::table('test_results')->where('user_id', $id)->orderBy('id', 'DESC')->first();
        $user_counts = DB::table('test_results')->where('user_id', $id)->count();

        if (!empty($insightresult)) {
            $cat_result = json_decode($insightresult->categories_result, true);

            foreach ($cat_result as $index => $cat_results) {
                $catname = Category::where('id', $cat_results['category_id'])->select('category_name')->first();

                $cat_result[$index]['category_name'] = $catname->category_name;
            }

            return compact('insightresult', 'cat_result', 'user_counts');
        }
    }

    /*
     * @created : January 28, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to insight page for next links.
     * @params  : None
     * @return  : None
     */

    public static function nextresult($testresult, $next_id, $nmax) {
        if (!empty($testresult)) {
            $current_date = (Carbon\Carbon::parse($testresult->created_at)->format('d/m/Y'));
            $maxlimit = $nmax->id;
            $cat_result = json_decode($testresult->categories_result, true);
            foreach ($cat_result as $index => $cat_results) {
                $catname = Category::where('id', $cat_results['category_id'])->select('category_name')->first();
                $cat_result[0]['next_id'] = $next_id;
                $cat_result[0]['current_date'] = $current_date;
                $cat_result[0]['maxlimit'] = $maxlimit;
                $cat_result[$index]['category_name'] = $catname->category_name;
            }

            return compact('cat_result');
        }
    }

    /*
     * @created : January 28, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to insight page for prev links.
     * @params  : None
     * @return  : None
     */

    public static function prevresult($testresult, $prev_id, $pmax) {
        if (!empty($testresult)) {
            $current_date = (Carbon\Carbon::parse($testresult->created_at)->format('d/m/Y'));
            $maxlimit = $pmax->id;
            $cat_result = json_decode($testresult->categories_result, true);
            foreach ($cat_result as $index => $cat_results) {
                $catname = Category::where('id', $cat_results['category_id'])->select('category_name')->first();
                $cat_result[0]['prev_id'] = $prev_id;
                $cat_result[0]['current_date'] = $current_date;
                $cat_result[0]['maxlimit'] = $maxlimit;
                $cat_result[$index]['category_name'] = $catname->category_name;
            }

            return compact('cat_result');
        }
    }

    /*
     * @created : January 28, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view page of parent and child compare.
     * @params  : None
     * @return  : None
     */

    public static function comparelayout($request, $tagresult) {
        $id = Auth::user()->id;
        foreach ($tagresult as $tagresults) {
            $childrecord = User::where('id', $tagresults['user_id'])->first();
            $tagresults = DB::table('test_results')->where('user_id', $tagresults['user_id'])->orderBy('id', 'DESC')->get()->toArray();

            $countresult = count($tagresults);
            $testresult = DB::table('test_results')->where('user_id', $id)->orderBy('id', 'DESC')->first();

            if (!empty($testresult)) {
                $cat_result = json_decode($testresult->categories_result, true);
                foreach ($cat_result as $index => $cat_results) {
                    $catname = Category::where('id', $cat_results['category_id'])->select('category_name')->first();
                    $cat_result[$index]['category_name'] = $catname->category_name;
                }
                return compact('testresult', 'cat_result', 'childrecord', 'tagresults', 'countresult');
            } else {

                return compact('testresult', 'childrecord', 'tagresults', 'countresult');
            }
        }
    }

    /*
     * @created : January 28, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view next child for compare view.
     * @params  : None
     * @return  : None
     */

    public static function nextchildlayout($request, $tagresult) {
        $id = Auth::user()->id;
        $childrecord = User::select('id', 'name', 'user_type', 'username')->where('id', $tagresult['user_id'])->first()->toArray();
        $testresult = DB::table('test_results')->where('user_id', $childrecord['id'])->orderBy('id', 'DESC')->first();
        $testscore = $testresult->score;
//        if (!empty($testresult)) {
//            $cat_result = json_decode($testresult->categories_result, true);
//            foreach ($cat_result as $index => $cat_results) {
//                $catname = Category::where('id', $cat_results['category_id'])->select('category_name')->first();
//                $cat_result[$index]['category_name'] = $catname->category_name;
//            }
//            return compact('testresult', 'cat_result', 'childrecord', 'tagresults', 'countresult');
//        } else {

        return compact('testresult', 'childrecord', 'testscore');
    }

    /*
     * @created : January 28, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view prev child for compare view.
     * @params  : None
     * @return  : None
     */

    public static function prevchildlayout($request, $tagresult) {
        $id = Auth::user()->id;
        $childrecord = User::select('id', 'name', 'user_type', 'username')->where('id', $tagresult['user_id'])->first()->toArray();
        $testresult = DB::table('test_results')->where('user_id', $childrecord['id'])->orderBy('id', 'DESC')->first();
        $testscore = $testresult->score;
//        if (!empty($testresult)) {
//            $cat_result = json_decode($testresult->categories_result, true);
//            foreach ($cat_result as $index => $cat_results) {
//                $catname = Category::where('id', $cat_results['category_id'])->select('category_name')->first();
//                $cat_result[$index]['category_name'] = $catname->category_name;
//            }
//            return compact('testresult', 'cat_result', 'childrecord', 'tagresults', 'countresult');
//        } else {

        return compact('testresult', 'childrecord', 'testscore');
    }

    /*
     * @created : Feb 25, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get level list.
     * @params  : none
     * @return  : users
     */

    public static function getlevels() {
        $levels = DB::table('levels')->orderBy('priority', 'asc')->where('status', 1)->get()->toArray();
        return $levels;
    }

    /*
     * @created : Feb 25, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get level list.
     * @params  : none
     * @return  : users
     */

    public static function getSublevels() {
        $sublevels = DB::table('sublevels')->orderBy('priority', 'asc')->where('status', 1)->get()->toArray();
        return $sublevels;
    }

}
