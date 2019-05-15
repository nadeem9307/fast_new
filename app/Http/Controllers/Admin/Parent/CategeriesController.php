<?php

namespace App\Http\Controllers\Admin\Parent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Validator;
use App\Model\ParentCategory;
use App\Helpers\Helper;
use Illuminate\Support\Facades\URL;
use Exception;

class CategeriesController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | CategeriesController
      |--------------------------------------------------------------------------
      |
      | Here is where you can create new Category for your application. These
      | controller used to add,edit, delete category with show all Category in data
      | table.
      |
     */

    /*
     * Create a new controller instance.
     *
     * @return void
     */

    /*
     * @created : Jan 2, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to view index page of Category
     * @params  : None
     * @return  : None
     */
    /* --------- Display Category listing----------- */

    public function index()
    {

        return view('admin.parent.categories.category');
    }

    /* --------------------- Save Category name here ------------------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save category data.
     * @params  : None
     * @return  : none
     */

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $rules = array(
                'category' => 'required|regex:/^[a-zA-Z ]+$/u',
            );
            /* --------------------- Category Name validation ------------------- */
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = "";
                if (isset($failedRules['category']))
                    $errorMsg = $failedRules['category'][0] . "\n";
                return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                /* --------------------- end Category Name validation ------------------- */
            } else {
                $category = ParentCategory::SaveCategory($request);

                if ($category['status'] == 'error') {
                    return (json_encode(array('status' => 'error', 'message' => "Category Name already exist.")));
                } else {
                    try {
                        if ($category->save()) {
                            return (json_encode(array('status' => 'success', 'message' => sprintf('Category Name "%s" successfully saved', $category->category_name))));
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to update Category Name "%s"', $category->category_name))));
                        }
                    } catch (\Illuminate\Database\QueryException $ex) {
                        $error_code = $ex->errorInfo[1];
                        if ($error_code == 1062) {
                            $result = $ex->getMessage();
                            return (json_encode(array('status' => 'error', 'message' => 'Category Name already exist')));
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

    /* --------------------- end Category data ------------------- */
    /* --------------------- Display Category Name listing ------------------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to display all  category name.
     * @params  : 4
     * @return  : category data
     */

    public function show(Request $request)
    {
        try {
            $perpage = $request->pagination['perpage'];
            $page = $request->pagination['page'];
            $draw = (isset($request->pagination['draw']) && ($request->pagination['draw'] != "") ? $request->pagination['draw'] : '1');
            $cate = (isset($request['query']['category_name']) && ($request['query']['category_name'] != "") ? $request['query']['category_name'] : '');

            if ($page == '1') {
                $offset = 0;
            } else if ($page) {
                $offset = ($page - 1) * $perpage;
            } else {
                $offset = 0;
            }
            $category = ParentCategory::getCategory($perpage, $page, $offset, $draw, $cate);
            return Response::json(array('data' => $category));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /* --------------------- end Category listing ------------------- */
    /* --------------------- edit Category here ------------------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to edit category name.
     * @params  : none
     * @return  : updated category
     */

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $status = "success";
                $category = ParentCategory::EditCategory($request);
                if ($category != 'error') {
                    return (json_encode(array('status' => $status, 'message' => $category)));
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

    /* --------------------- End category section ------------------- */
    /* --------------------- Delete a category name here ------------------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to delete category name.
     * @params  : none
     * @return  : none
     */

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            try {
                $cat = ParentCategory::deleteCategory($request);
                if ($cat == 'success') {
                    return (json_encode(array('status' => 'success', 'message' => "Category Deleted Successfully")));
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


    /* --------------------- End delete section here ------------------- */
    /* ---------- In this Function we can Activate category status----------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public 
     * @Purpose : This function is use to activate status of a category name.
     * @params  : none
     * @return  : status
     */

    public function CategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            try {
                $cat = ParentCategory::ActivateDeactivateStatus($request);
                if ($cat == 'success') {
                    return (json_encode(array('status' => 'success', 'message' => "Updated Successfully")));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => $cat->getMessage())));
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
}
