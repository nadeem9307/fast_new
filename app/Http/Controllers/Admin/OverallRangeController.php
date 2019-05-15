<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OverAllRange;
use App\Helpers\Helper;
use Response;
use Validator;
use Exception;

class OverallRangeController extends Controller
{
    /*
     * @created : Jan 24, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to return view of  Overall Interpretation Data.
     * @params  : 4
     * @return  : view
     */

    public function index()
    {
        try {
            return view('admin.overall_interpretation.index');
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
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save interpretattion
     * @params  : None
     * @return  : None
     */

    public function store(request $request)
    {
        if ($request->ajax()) {
            $rules = array(
                'min_range' => 'required',
                'max_range' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = "";
                if (isset($failedRules['min_range']))
                    $errorMsg = $failedRules['min_range'][0] . "\n";
                if (isset($failedRules['max_range']))
                    $errorMsg = $failedRules['max_range'][0] . "\n";
                return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                /* --------------------- end range validation ------------------- */
            } else {
                $interpretation = OverAllRange::SaveRange($request);
                if ($interpretation['status'] == 'error') {
                    return (json_encode(array('status' => 'error', 'message' => "Range already exist.")));
                } else {
                    try {
                        if ($interpretation->save()) {
                            return (json_encode(array('status' => 'success', 'message' => 'Interpretation data  successfully saved')));
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => 'Failed to Interpretation data ')));
                        }
                    } catch (\Illuminate\Database\QueryException $ex) {
                        $error_code = $ex->errorInfo[1];
                        if ($error_code == 1062) {
                            $result = $ex->getMessage();
                            return (json_encode(array('status' => 'error', 'message' => 'Interpretation  already exist')));
                        } else {
                            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
                        }
                    } catch (\Exception $e) {
                        Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                        return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
                    }
                }
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Jan 21, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to display interpretation by category
     * @params  : None
     * @return  : None
     */

    public function show(Request $request)
    {
        try {
            $perpage = $request->datatable['pagination']['perpage'];
            $page = $request->datatable['pagination']['page'];
            $draw = (isset($request->datatable['pagination']['draw']) && ($request->datatable['pagination']['draw'] != "") ? $request->datatable['pagination']['draw'] : '1');
            if ($page == '1') {
                $offset = 0;
            } else if ($page) {
                $offset = ($page - 1) * $perpage;
            } else {
                $offset = 0;
            }
            $overall = OverAllRange::getOverAllRanges($perpage, $page, $offset, $draw);
            return Response::json(array('data' => $overall));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Jan 22, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to edit interpretation details.
     * @params  : none
     * @return  : updated interpretation
     */

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $status = "success";
                $range = OverAllRange::EditRange($request);
                if ($range != false) {
                    return (json_encode(array('status' => $status, 'message' => $range)));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => 'No Data Found')));
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                $status = "error";
                return (json_encode(array('status' => $status, 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }

    /*
     * @created : Jan 22, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to delete interpretation details.
     * @params  : none
     * @return  : delete interpretation
     */

    public function deleteRange(Request $request)
    {
        if ($request->ajax()) {
            try {
                if ($request->id) {
                    $interpretation = OverAllRange::find($request->id);
                    if ($interpretation->delete())
                        return (json_encode(array('status' => 'success', 'message' => "Range Deleted Successfully")));
                }
                return (json_encode(array('status' => 'error', 'message' => "No Such Record is Found!!!")));
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                $status = "error";
                return (json_encode(array('status' => $status, 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
            }
        } else {
            return abort(404);
        }
    }


    /*
     * @created : Jan 22, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to Add Range Summary.
     * @params  : none
     * @return  : none
     */


    public function saveRangeSummary(Request $request)
    {
        if ($request->ajax()) {
            if ($request->id) {
                $summary = OverAllRange::find($request->id);
                $summary->summary = $request->summary;
                try {
                    if ($summary->save()) {
                        return (json_encode(array('status' => 'success', 'message' => 'Summary data  successfully saved')));
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => 'Failed to Summary data ')));
                    }
                } catch (\Illuminate\Database\QueryException $ex) {
                    $error_code = $ex->errorInfo[1];
                    if ($error_code == 1062) {
                        $result = $ex->getMessage();
                        return (json_encode(array('status' => 'error', 'message' => 'Summary  already exist')));
                    } else {
                        Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                        return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
                    }
                } catch (\Exception $e) {
                    Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                    return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
                }
            }
        } else {
            return abort(404);
        }
    }
}
