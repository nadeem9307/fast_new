<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\TestResult;
use App\User;
use Auth;
use DB;

class Tag_Parents extends Model {
    /*
      |--------------------------------------------------------------------------
      | Model for Parent and Child
      |--------------------------------------------------------------------------
      |
      | Here is we can make a function for parent and child view layout for dynamic
      | layout page with next and previous child or parent functionality.

     */

    public $table = "tag_parents";

    /*
     * @created : January 21, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view index page of child.
     * @params  : None
     * @return  : None
     */

    public static function childlayout($tagresult) {
        $id = Auth::user()->id;
        $next_id = TestResult::where('user_id', '<', $tagresult[0]['user_id'])->max('user_id');
        $nextresult_id = Tag_Parents::where('parent_id', $id)->orderBy('id', 'DESC')->first();
        $nextresultid = $nextresult_id->id;
        $nmax = TestResult::where('user_id', $next_id)->orderBy('id', 'ASC')->first();
        foreach ($tagresult as $tagresults) {
            $childrecord = User::where('id', $tagresults['user_id'])->first();
            $user_counts = DB::table('tag_parents')->where('parent_id', $tagresults['parent_id'])->count();
            $testresult = DB::table('test_results')->where('user_id', $tagresults['user_id'])->orderBy('id', 'DESC')->first();
         
            if (!empty($testresult)) {
                $maxnchild = $nmax['user_id'];
                $cat_result = json_decode($testresult->categories_result, true);
                foreach ($cat_result as $index => $cat_results) {
                    $catname = Category::where('id', $cat_results['category_id'])->select('category_name')->first();
                    $cat_result[$index]['category_name'] = $catname->category_name;
                }
            }
            return compact('testresult', 'cat_result', 'user_counts', 'childrecord', 'nextresultid', 'maxnchild');
        }
    }

    /*
     * @created : January 27, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view next page of child.
     * @params  : None
     * @return  : None
     */

    public static function nextchildlayout($tagresult, $next_id) {
        $id = Auth::user()->id;
        $nmax = TestResult::where('user_id', $next_id)->orderBy('id', 'ASC')->first();
        foreach ($tagresult as $tagresults) {
            $childrecord = User::where('id', $tagresults['user_id'])->first();
            $user_counts = Tag_Parents::where('parent_id', $tagresults['parent_id'])->count();
            $testresult = TestResult::where('user_id', $tagresults['user_id'])->orderBy('id', 'DESC')->first();
            if (!empty($testresult)) {
                $maxnchild = $nmax->user_id;
                $cat_result = json_decode($testresult->categories_result, true);
                foreach ($cat_result as $index => $cat_results) {
                    $catname = Category::where('id', $cat_results['category_id'])->select('category_name')->first();
                    $cat_result[$index]['category_name'] = $catname->category_name;
                }
            }
            return compact('testresult', 'cat_result', 'user_counts', 'childrecord', 'maxnchild', 'nmax');
        }
    }

    /*
     * @created : January 27, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view previous page of child.
     * @params  : None
     * @return  : None
     */

    public static function prevchildlayout($tagresult, $prev_id) {
        $id = Auth::user()->id;
        $maxchild = TestResult::where('user_id', $prev_id)->orderBy('id', 'DESC')->first();
        foreach ($tagresult as $tagresults) {
            $childrecord = User::where('id', $tagresults['user_id'])->first();
            $user_counts = Tag_Parents::where('parent_id', $tagresults['parent_id'])->count();
            $testresult = TestResult::where('user_id', $tagresults['user_id'])->orderBy('id', 'DESC')->first();
            if (!empty($testresult)) {
                $maxnchild = $maxchild->user_id;
                $cat_result = json_decode($testresult->categories_result, true);
                foreach ($cat_result as $index => $cat_results) {
                    $catname = Category::where('id', $cat_results['category_id'])->select('category_name')->first();

                    $cat_result[$index]['category_name'] = $catname->category_name;
                }
            }
            return compact('testresult', 'cat_result', 'user_counts', 'childrecord', 'maxnchild');
        }
    }
}
