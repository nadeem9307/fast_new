<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Interpretation;
use App\Helpers\Helper;
use Response;
use Validator;
use Exception;

class InterpretationController extends Controller
{
    /*
     * @created : Jan 21, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to range listing manage to category wise Interpretation.
     * @params  : None
     * @return  : None
     */
    /* --------- Display Ranges listing----------- */

    public function index(request $request, $id)
    {
        try {
            $category_id = $id;
            $datas = Interpretation::GetInterpretationRange($id);
            $data = $datas['data'];
            $cat = $datas['cat'];
            $cate_data = $datas['cate_data'];
            return view('admin.interpretation.interpretation_by_category', compact('data', 'category_id', 'cate_data', 'cat'));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());;
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
                'category_id' => 'required',
                'interpretation' => 'required',
                'min_range' => 'required',
                'max_range' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = "";
                if (isset($failedRules['category_id']))
                    $errorMsg = $failedRules['category_id'][0] . "\n";
                if (isset($failedRules['interpretation']))
                    $errorMsg = $failedRules['interpretation'][0] . "\n";
                if (isset($failedRules['range']))
                    $errorMsg = $failedRules['range'][0] . "\n";
                return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                /* --------------------- end  validation ------------------- */
            } else {
                $interpretation = Interpretation::SaveInterpretation($request);
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
                        Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());;
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

    public function show(Request $request, $id)
    {
        try {
            $cat_id = $id;
            $perpage = $request->datatable['pagination']['perpage'];
            $page = $request->datatable['pagination']['page'];
            $draw = (isset($request->datatable['pagination']['draw']) && ($request->datatable['pagination']['draw'] != "") ? $request->datatable['pagination']['draw'] : '1');
            $cate = (isset($request->datatable['query']['category']) && ($request->datatable['query']['category'] != "") ? $request->datatable['query']['user_role'] : '');
            if ($page == '1') {
                $offset = 0;
            } else if ($page) {
                $offset = ($page - 1) * $perpage;
            } else {
                $offset = 0;
            }
            $category = Interpretation::getInterByCategory($perpage, $page, $offset, $draw, $cat_id);
            return Response::json(array('data' => $category));
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
                $interpretation = Interpretation::EditInterpretation($request);
                if ($interpretation !== false) {
                    return (json_encode(array('status' => $status, 'message' => $interpretation)));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => 'No Data Found')));
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                $status = "error";
                $result = $ex->getMessage();
                return (json_encode(array('status' => $status, 'message' => $result)));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                $err_result = $e->getMessage();
                return (json_encode(array('status' => 'error', 'message' => $err_result)));
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

    public function deleteInterpretation(Request $request)
    {
        if ($request->ajax()) {
            try {
                if ($request->id) {
                    $interpretation = Interpretation::find($request->id);
                    if ($interpretation->delete())
                        return (json_encode(array('status' => 'success', 'message' => "Interpretation Deleted Successfully")));
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

    /*
     * @created : Jan 22, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to range listing manage to category wise Interpretation.
     * @params  : none
     * @return  : none
     */

    public function SaveCategoryInterpretation(Request $request)
    {
        if ($request->ajax()) {
            try {
                $rules = array(
                    'category_id' => 'required',
                    'range_id' => 'required',
                    'interpretation' => 'required',
                );
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['category_id']))
                        $errorMsg = $failedRules['category_id'][0] . "\n";
                    if (isset($failedRules['range_id']))
                        $errorMsg = $failedRules['range_id'][0] . "\n";
                    if (isset($failedRules['interpretation']))
                        $errorMsg = $failedRules['interpretation'][0] . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                    /* --------------------- end  validation ------------------- */
                } else {
                    $interpretation = Interpretation::SaveCatInterpretation($request);
                    if ($interpretation['status'] == 'error') {
                        return (json_encode(array('status' => 'error', 'message' => "Interpretation already exist.")));
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
