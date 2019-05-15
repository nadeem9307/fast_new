<?php

namespace App\Http\Controllers\Admin;

use App\Model\Semester;
use App\Http\Controllers\Controller;
use Response;
use Validator;
use Illuminate\Http\Request;
use App\Model\SubLevels;
use App\Model\Levels;
use App\Helpers\Helper;
use Exception;


class SemesterController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Semester Controller
      |--------------------------------------------------------------------------
      |
      | Here is we can register new semester for your application. These
      | controller used to add,edit semester with show all semester in data
      | table.
      |
     */

    /*
     * @created : Feb 14, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view index page of country.
     * @params  : None
     * @return  : None
     */

    public function index($sublevel_id)
    {
        try {
            $sublevel_data = SubLevels::find($sublevel_id);
            if ($sublevel_data) {
                return view('admin.semester.index', compact('sublevel_data'));
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
     * @created : Feb 14, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get All Semesters.
     * @params  : None
     * @return  : None
     */

    public function getAllSemesters(Request $request, $id)
    {
        try {
            if ($id) {
                $exist = SubLevels::find($id);
                if ($exist) {
                    $semesters = Semester::allSemester($request, $id);
                    return Response::json(array('data' => $semesters));
                }
                abort(403);
            }
            return Response::json(array('status' => 'error', 'message' => 'No data found.'));
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
     * @created : Feb 14, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to save semester details.
     * @params  : None
     * @return  : none
     */

    public function storeSemester(Request $request)
    {
        if ($request->ajax()) {
            $rules = array(
                'sublevels' => 'required',
                'semester_name' => 'required',
                'priority_order' => 'required',
            );
            /* --------------------- semester data  validation ------------------- */
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = "";
                if (isset($failedRules['sublevels']))
                    $errorMsg = $failedRules['sublevels'][0] . "\n";
                if (isset($failedRules['semester_name']))
                    $errorMsg = $failedRules['semester_name'][0] . "\n";
                if (isset($failedRules['priority_order']))
                    $errorMsg = $failedRules['priority_order'][0] . "\n";
                return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                /* --------------------- end semester data  validation ------------------- */
            } else {
                $addsemester = Semester::Savesemester($request);
                if ($addsemester['status'] == 'error') {
                    return (json_encode(array('status' => 'error', 'message' => "Semester already exists.")));
                } else {
                    try {
                        if ($addsemester->save()) {
                            return (json_encode(array('status' => 'success', 'message' => sprintf('Semester "%s" successfully saved', $addsemester->sem_name))));
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to update Semester "%s"', $addsemester->sem_name))));
                        }
                    } catch (\Illuminate\Database\QueryException $ex) {
                        $error_code = $ex->errorInfo[1];
                        if ($error_code == 1062) {
                            $result = $ex->getMessage();
                            return (json_encode(array('status' => 'error', 'message' => 'Semester already exists.')));
                        } else {
                            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                            $result = $ex->getMessage();
                            return (json_encode(array('status' => 'error', 'message' => $result)));
                        }
                    } catch (\Exception $e) {
                        Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                        $err_result = $e->getMessage();
                        return (json_encode(array('status' => 'error', 'message' => $err_result)));
                    }
                }
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Feb 14, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to edit semester
     * @params  : None
     * @return  : None
     */

    public function editSemester(Request $request)
    {
        if ($request->ajax()) {
            try {
                $status = "success";
                $semester = Semester::find($request->id);
                if ($semester) {
                    return (json_encode(array('status' => $status, 'message' => $semester)));
                }
                return (json_encode(array('status' => 'error', 'message' => 'No Data found.')));
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
     * @created : Feb 14, 2019
     * @author  : Nitish
     * @access  : public 
     * @Purpose : This function is use to activate status of a Semester.
     * @params  : none
     * @return  : status
     */

    public function SemesterStatus(Request $request)
    {
        if ($request->ajax()) {
            try {
                $semester = Semester::ArchiveStatus($request);
                if ($semester == 'success') {
                    return (json_encode(array('status' => 'success', 'message' => "Updated Successfully")));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => $user->getMessage())));
                }

                return (json_encode(array('status' => 'error', 'message' => "No Such Record is Found!!!")));
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
