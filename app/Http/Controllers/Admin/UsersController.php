<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\User;
use Response;
use Validator;
use DB;
use App\Model\TestResult;
use Exception;


class UsersController extends Controller
{
    /*
     * @created : Feb 05 , 2019
     * @author  : Anup Singh
     * @access  : public
     * @Purpose : This function is used to get users view.
     * @params  : None
     * @return  : None
     */

    public function index()
    {
        try {
            $country = User::getCountries();
            return view('admin.users.index')->with(['country' => $country]);
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /* --------------------- Display Users Name listing ------------------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to display all  Users data.
     * @params  : 4
     * @return  : Users data
     */

    public function show(Request $request)
    {
        try {
            $users = User::getAllUsers($request);
            return Response::json(array('data' => $users));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            $err_result = $e->getMessage();
            return (json_encode(array('status' => 'error', 'message' => $err_result)));
        }
    }

    /* --------------------- end users listing ------------------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save user details.
     * @params  : None
     * @return  : none
     */

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $rules = array(
                'country_id' => 'required',
                'user_type' => 'required',
                'name' => 'required|not_in:0',
                'username' => 'required|not_in:0',
                'password' => 'required',
            );
            /* --------------------- Users data validation ------------------- */
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = "";
                if (isset($failedRules['country_id']))
                    $errorMsg = $failedRules['country_id'][0] . "\n";
                if (isset($failedRules['user_type']))
                    $errorMsg = $failedRules['user_type'][0] . "\n";
                if (isset($failedRules['name']))
                    $errorMsg = $failedRules['name'][0] . "\n";
                if (isset($failedRules['username']))
                    $errorMsg = $failedRules['username'][0] . "\n";
                if (isset($failedRules['email']))
                    $errorMsg = $failedRules['email'][0] . "\n";
                if (isset($failedRules['password']))
                    $errorMsg = $failedRules['password'][0] . "\n";
                return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                /* --------------------- end User Name validation ------------------- */
            } else {
                $user = User::Saveuser($request);
                if ($user['status'] == 'error') {
                    return (json_encode(array('status' => 'error', 'message' => "Username already exist.")));
                } else {
                    try {
                        if ($user->save()) {
                            return (json_encode(array('status' => 'success', 'message' => sprintf('User data "%s" successfully saved', $user->username))));
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to update User "%s"', $user->username))));
                        }
                    } catch (\Illuminate\Database\QueryException $ex) {
                        $error_code = $ex->errorInfo[1];
                        if ($error_code == 1062) {
                            $result = $ex->getMessage();
                            return (json_encode(array('status' => 'error', 'message' => 'user  already exist')));
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
     * @created : Jan 4, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to edit user details.
     * @params  : none
     * @return  : updated user
     */

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $status = "success";
                $user = User::EditUser($request);
                if ($user != 'error') {
                    return (json_encode(array('status' => $status, 'message' => $user)));
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
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public 
     * @Purpose : This function is use to activate status of a user.
     * @params  : none
     * @return  : status
     */

    public function UserStatus(Request $request)
    {
        if ($request->ajax()) {
            try {
                $user = User::ArchiveStatus($request);
                if ($user == 'success') {
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
