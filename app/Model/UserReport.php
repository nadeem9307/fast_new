<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model {
    /*
      |--------------------------------------------------------------------------
      | UserReport Model
      |--------------------------------------------------------------------------
      |
      | Here is we can make a function for next previous of user report.

     */

    public $table = "users";

    /*
     * @created : January 31, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to view user report of test.
     * @params  : None
     * @return  : None
     */

    public static function getUsersResult($request, $id,$fast_score) {
        $cat_result = "";
        $testresult = TestResult::select('test_results.id as test_id', 'test_results.*')->selectRaw("IFNULL((SELECT MAX(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id < test_id AND fi_test_results.user_id = $id),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id > test_id AND fi_test_results.user_id = $id),'') as prev_id")->where('user_id', $id)->orderBy('test_results.id', 'DESC')->first();
        if ($testresult) {
            $cat_result = json_decode($testresult->categories_result, true);
            if (!empty($cat_result)) {
                foreach ($cat_result as $key => $value) {
                    $category_data = Category::select('category_name')->where('id', $value['category_id'])->first();
                    $cat_result[$key]['category_name'] = $category_data->category_name;
                }
            }
        }
         $summary = OverAllRange::where('min_range', '<=', $fast_score)->where('max_range', '>', $fast_score)->orwhere('max_range', '=', $fast_score)->select('summary')->first();
        return compact('testresult', 'cat_result','summary');
    }
    
    
    /*----------------parent user-----------------*/
     /*
     * @created : January 31, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to view user report of test.
     * @params  : None
     * @return  : None
     */

    public static function getParentUsersResult($request, $id,$fast_score) {
        $cat_result = "";
        $testresult = ParentTestResult::select('parent_test_results.id as test_id', 'parent_test_results.*')->selectRaw("IFNULL((SELECT MAX(fi_parent_test_results.id) FROM fi_parent_test_results WHERE fi_parent_test_results.id < test_id AND fi_parent_test_results.user_id = $id),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_parent_test_results.id) FROM fi_parent_test_results WHERE fi_parent_test_results.id > test_id AND fi_parent_test_results.user_id = $id),'') as prev_id")->where('user_id', $id)->orderBy('parent_test_results.id', 'DESC')->first();
        if ($testresult) {
            $cat_result = json_decode($testresult->categories_result, true);
            if (!empty($cat_result)) {
                foreach ($cat_result as $key => $value) {
                    $category_data = ParentCategory::select('category_name')->where('id', $value['category_id'])->first();
                    $cat_result[$key]['category_name'] = $category_data->category_name;
                }
            }
        } $summary = OverAllRange::where('min_range', '<=', $fast_score)->where('max_range', '>', $fast_score)->orwhere('max_range', '=', $fast_score)->select('summary')->first();
        return compact('testresult', 'cat_result','summary');
    }
}
