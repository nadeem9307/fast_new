<?php

namespace App\Http\Controllers\Admin\Parent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserReport;
use App\Model\ParentTestResult;
use App\Model\ParentCategory;
use App\Helpers\Helper;
use Exception;


class UserReportController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | UserReportController
      |--------------------------------------------------------------------------
      |
      | Here we can get all the user view test report pages.
     */
    /*
     * @created : Jan 30, 2019
     * @author  : Mohd Nadeem
     * @access  : public 
     * @Purpose : This function is use to display user test report.
     * @params  : none
     * @return  : report
     */

    public function getUserReport(Request $request, $id) {
        try {
            $user = UserReport::find($id);
            $fast_score = $user->fast_score;
            $data = UserReport::getParentUsersResult($request, $id,$fast_score);
            $testresult = $data['testresult'];
            $cat_result = $data['cat_result'];
            $summary = $data['summary'];
            return view('admin.parent.users.test_report', compact('cat_result', 'user', 'summary'))->with(['testresult' => $testresult]);
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
     * @created : Feb 08, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to user report page for next results.
     * @params  : None
     * @return  : None
     */

    public function getuserTestData(Request $request) {
        try {
            $data['testresult'] = TestResult::select('test_results.id as test_id', 'test_results.created_at', 'test_results.score', 'test_results.overall_interpretation', 'test_results.categories_result')->selectRaw("IFNULL((SELECT MAX(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id<test_id AND fi_test_results.user_id = $request->child_id),'') as next_id")->selectRaw("IFNULL((SELECT MIN(fi_test_results.id) FROM fi_test_results WHERE fi_test_results.id>test_id AND  fi_test_results.user_id = $request->child_id),'') as prev_id")->where('id', $request->id)->first();
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

}
