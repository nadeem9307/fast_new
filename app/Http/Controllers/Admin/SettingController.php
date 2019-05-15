<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Auth;
use App\Model\Settings;
use Response;
use Exception;

class SettingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    /* -------------- admin setting ----------------- */
    /*
     * @created : Feb 04, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to setting for all users.
     * @params  : None
     * @return  : none
     */

    public function getUserSetting()
    {
        try {
            $user = Auth::user();
            $setting = Settings::where('user_id', $user->id)->first();
            $default_setting = array();
            if (!empty($setting)) {
                $default_setting = json_decode($setting->settings_json, true);
            }
            return view('admin.setting.index', compact(['default_setting', 'setting']));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Feb 04, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to setting for all users.
     * @params  : None
     * @return  : none
     */

    public function SaveTestSetting(Request $request)
    {
        if ($request->ajax()) {
            try {

                $user_id = Auth::user()->id;
                $number_of_limit = $request->test_limit;
                $id = $request->id;
                $data = array();
                $data['user_id'] = $user_id;
                $data['retake_test_limit'] = $request->number_of_time;
                $data['category_wise_question_limit'] = $request->number_of_question;
                if ($request->id) {
                    /* --------------------- setting update ------------------- */
                    $setting = Settings::find($request->id);
                } else {
                    /* --------------------- if new setting ------------------- */
                    $setting = new Settings();
                }
                $result_data = json_encode($data);
                $setting->user_id = $user_id;
                $setting->settings_json = $result_data;

                if ($setting->save()) {
                    return (json_encode(array('status' => 'success', 'message' => 'setting data successfully saved')));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => 'Failed to update setting')));
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
