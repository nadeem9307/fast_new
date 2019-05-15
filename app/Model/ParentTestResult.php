<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use App\User;
use Carbon;

class ParentTestResult extends Model {
    /*
      |--------------------------------------------------------------------------
      | TestResult Model
      |--------------------------------------------------------------------------
      |
      | Here is we can make a function for overview, insight and child page
      | layout score.

     */

    public $table = "parent_test_results";

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
            $range = OverAllRange::where('min_range', '<=', $cat_score);
            if ($cat_score == 100) {
                $range = $range->where('max_range', '>=', $cat_score);
            } else {
                $range = $range->where('max_range', '>', $cat_score);
            }
             $range = $range->select('id')->first();
            
            if (!empty($range)) {
                $interpretations = ParentInterpretation::where('category_id', $cat_id)->where('range_id', $range->id)
                                ->select('interpretation')->first();
                $range_id = $range->id;
                if (!empty($interpretations)) {
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
            $overall = ParentOverAllInterpretation::where('category_ids', $cate_ids)->where('individual_range_ids', $inds_ids)->where('overall_range', $id->id)
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

        $result = DB::table('parent_questions')
                ->join('parent_answers', 'parent_questions.id', '=', 'parent_answers.question_id')
                ->select('parent_questions.category_id', 'parent_answers.correct_options')
                ->where('parent_questions.id', $question_id)
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

        $result = DB::table('parent_questions')
                        ->join('parent_answers', 'parent_questions.id', '=', 'parent_answers.question_id')
                        ->select('parent_questions.category_id', 'parent_answers.correct_options')
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

        $result = DB::table('parent_questions')
                        ->join('parent_answers', 'parent_questions.id', '=', 'parent_answers.question_id')
                        ->select('parent_questions.category_id', 'parent_answers.options')
                        ->where('parent_answers.question_id', $question_id)
                        ->where('parent_answers.correct_options', '1')
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
        $result = DB::table('parent_questions')
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

        $testresult = DB::table('parent_test_results')->where('user_id', $id)->orderBy('id', 'DESC')->first();
        if (!empty($testresult)) {

            $cat_result = json_decode($testresult->categories_result, true);

            foreach ($cat_result as $index => $cat_results) {
                $catname = ParentCategory::where('id', $cat_results['category_id'])->select('category_name')->first();
                //print_r($catname); die;
                $cat_result[$index]['category_name'] = $catname->category_name;
            }
//          dd($cat_result);
            $summary = OverAllRange::where('min_range', '<=', $fast_score)->where('max_range', '>', $fast_score)->orwhere('max_range', '=', $fast_score)->select('summary')->first();

            return compact('testresult', 'cat_result', 'summary');
        }
    }

}
