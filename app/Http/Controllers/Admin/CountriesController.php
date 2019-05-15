<?php

namespace App\Http\Controllers\Admin;

use App\Model\Countries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Validator;
use App\Helpers\Helper;
use Illuminate\Routing\Route;
use DB;
use Exception;

class CountriesController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | CountriesController
      |--------------------------------------------------------------------------
      |
      | Here is we can register new country for your application. These
      | controller used to add,edit country with show all country in data
      | table.
      |
     */


    /*
     * @created : January 03, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to view index page of country.
     * @params  : None
     * @return  : None
     */

    public function index()
    {
        try {
            return view('admin.countries.index');
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : January 03, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get All countries.
     * @params  : None
     * @return  : None
     */

    public function getCountry(Request $request)
    {
        try {
//            print_r($request->all());
//            die;
            $countries = Countries::allCountry($request);
            return Response::json(array('data' => $countries));
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
     * @created : January 03, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to add new country.
     * @params  : None
     * @return  : None
     */

    public function addcountry(Request $request)
    {
        if ($request->id == '') {
            $rules = array(
                'country_name' => 'required|unique:countries',
                'short_code' => 'required|unique:countries',
                'country_code' => 'required|unique:countries',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = "";
                if (isset($failedRules['country_name']))
                    $errorMsg = $failedRules['country_name'][0] . "\n";
                if (isset($failedRules['short_code']))
                    $errorMsg = $failedRules['short_code'][0] . "\n";
                if (isset($failedRules['country_code']))
                    $errorMsg = $failedRules['country_code'][0] . "\n";
                return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
            }
            $countries = new Countries();
            $countries->country_name = $request->country_name;
            $countries->short_code = $request->short_code;
            $countries->country_code = $request->country_code;
            try {
                $countries->save();
                return (json_encode(array('status' => 'success', 'message' => sprintf('Country "%s" successfully saved', $countries->country_name))));
            } catch (\Illuminate\Database\QueryException $ex) {
                $error_code = $ex->errorInfo[1];
                if ($error_code == 1062) {
                    $result = $ex->getMessage();
                    Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                    return (json_encode(array('status' => 'error', 'message' => 'Country already exist')));
                }
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                $err_result = $e->getMessage();
                return (json_encode(array('status' => 'error', 'message' => $err_result)));
            }
        } else {
            $countries = Countries::find($request->id);
            $id = $request->id;
            if ($request->country_name != '') {
                $check_name = Countries::where(['country_name' => $request->country_name])
                    ->where(function ($query) use ($id) {
                        if (isset($id)) {
                            $query->where('id', '<>', $id);
                        }
                    })->exists();
                if ($check_name) {
                    return (json_encode(array('status' => 'error', 'message' => 'Country name already exist')));
                }
                $countries->country_name = $request->country_name;
            }
            if ($request->short_code != '') {
                $check_code = Countries::where(['short_code' => $request->short_code])
                    ->where(function ($query) use ($id) {
                        if (isset($id)) {
                            $query->where('id', '<>', $id);
                        }
                    })->exists();
                if ($check_code) {
                    return (json_encode(array('status' => 'error', 'message' => 'Country short code already exist')));
                }
                $countries->short_code = $request->short_code;
            }
            if ($request->country_code != '') {
                $country_code = Countries::where(['country_code' => $request->country_code])
                    ->where(function ($query) use ($id) {
                        if (isset($id)) {
                            $query->where('id', '<>', $id);
                        }
                    })->exists();
                if ($country_code) {
                    return (json_encode(array('status' => 'error', 'message' => 'Country Code already exist')));
                }
                $countries->country_code = $request->country_code;
            }
            try {
                $countries->save();
                return (json_encode(array('status' => 'success', 'message' => sprintf('Country "%s" successfully updated', $countries->country_name))));
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                $error_code = $ex->errorInfo[1];
                if ($error_code == 1062) {
                    $result = $ex->getMessage();
                    return (json_encode(array('status' => 'error', 'message' => 'Country already exist')));
                }
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                $err_result = $e->getMessage();
                return (json_encode(array('status' => 'error', 'message' => $err_result)));
            }
        }
    }

    /*
     * @created : January 03, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to edit country
     * @params  : None
     * @return  : None
     */

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $status = "success";
                $result = Countries::editcountry($request);
                return (json_encode(array('status' => $status, 'message' => $result)));
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
     * @created : January 03, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to change status of specific country
     * @params  : None
     * @return  : None
     */

    public function activate(Request $request)
    {
        if ($request->ajax()) {
            try {
                if ($request->id) {
                    $country = Countries::find($request->id);
                    $country->status = 1;
                    if ($country->save())
                        return (json_encode(array('status' => 'success', 'message' => "Country activated successfully")));
                }
                return (json_encode(array('status' => 'error', 'message' => "No such record found!!!")));
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
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
     * @created : January 03, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to change status of specific country
     * @params  : None
     * @return  : None
     */

    public function deactivate(Request $request)
    {
        if ($request->ajax()) {
            try {
                if ($request->id) {
                    $country = Countries::find($request->id);
                    $country->status = 2;
                    if ($country->save())
                        return (json_encode(array('status' => 'success', 'message' => "Country deactivated successfully")));
                }
                return (json_encode(array('status' => 'error', 'message' => "no such record found!!!")));
            } catch (\Illuminate\Database\QueryException $ex) {
                Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
                return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
            } catch (\Exception $e) {
                Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
                $err_result = $e->getMessage();
                return (json_encode(array('status' => 'error', 'message' => $err_result)));
            }
        } else {
            return abort(404);
        }
    }
}
