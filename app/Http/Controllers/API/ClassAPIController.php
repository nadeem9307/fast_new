<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Response;
use Validator;
use DB;
use App\Model\Levels;
use App\Model\SubLevels;
use Exception;

class ClassAPIController extends Controller {

    public function __construct() {
        //$this->middleware('isAdmin');
    }

    public function AddLevel(Request $request) {
        try {
           
            $rules = array('id' => 'required|numeric', 'level_name' => 'required', 'priority' => 'required|numeric', 'status' => 'required|numeric');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = [];
                if (isset($failedRules['id'])) {
                    $errorMsg[] = $failedRules['id'][0];
                }
                if (isset($failedRules['level_name'])) {
                    $errorMsg[] = $failedRules['level_name'][0];
                }
                if (isset($failedRules['priority'])) {
                    $errorMsg[] = $failedRules['priority'][0];
                }
                if (isset($failedRules['status'])) {
                    $errorMsg[] = $failedRules['status'][0];
                }

                return response(array('status' => 'error', 'status_code' => '500', 'error' => implode(',', $errorMsg)), 500);
            } else {
                $data = ['id' => $request->id,
                    'level_name' => $request->level_name,
                    'priority' => $request->priority,
                    'status' => $request->status,];
                if (Levels::where('id', $request->id)->count()) {
                    Levels::where('id', $request->id)->update($data);
                    $message = 'Level updated successfully';
                } else {
                    Levels::insert($data);
                    $message = 'Level added successfully';
                }

                // Here we add level combination

                return response(array('status' => 'success', 'status_code' => '200', 'success' => $message), 200);
            }
        } catch (Exception $ex) {
            //dd($ex->getMessage());
            return response(array('status' => 'error', 'status_code' => '505', 'error' => $ex->getMessage()), 505);
        }
    }

    public function AddSubLevel(Request $request) {

        try {
            $rules = array('id' => 'required|numeric', 'sublevel_name' => 'required', 'priority' => 'required|numeric', 'status' => 'required|numeric');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = [];
                if (isset($failedRules['id'])) {
                    $errorMsg[] = $failedRules['id'][0];
                }
                if (isset($failedRules['sublevel_name'])) {
                    $errorMsg[] = $failedRules['sublevel_name'][0];
                }
                if (isset($failedRules['priority'])) {
                    $errorMsg[] = $failedRules['priority'][0];
                }
                if (isset($failedRules['status'])) {
                    $errorMsg[] = $failedRules['status'][0];
                }

                return response(array('status' => 'error', 'status_code' => '500', 'error' => implode(',', $errorMsg)), 500);
            } else {
                $data = ['id' => $request->id,
                    'sublevel_name' => $request->sublevel_name,
                    'priority' => $request->priority,
                    'status' => $request->status,];
                if (SubLevels::where('id', $request->id)->count()) {
                    SubLevels::where('id', $request->id)->update($data);
                    $message = 'Sub level updated successfully';
                } else {
                    SubLevels::insert($data);
                    $message = 'Sub level inserted successfully';
                }

                return response(array('status' => 'success', 'status_code' => '200', 'success' => $message), 200);
            }
        } catch (Exception $ex) {
            return response(array('status' => 'error', 'status_code' => '505', 'error' => $ex->getMessage()), 505);
        }
    }

    public function DeleteLevel(Request $request) {

        try {
            $rules = array('level_id' => 'required|numeric');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = [];
                if (isset($failedRules['level_id'])) {
                    $errorMsg[] = $failedRules['level_id'][0];
                }

                return response(array('status' => 'error', 'status_code' => '500', 'error' => implode(',', $errorMsg)), 500);
            } else {
                $levelId = $request->level_id;
                $find_id = Levels::where('id',$levelId)->first();
                if(!$find_id) {
                    $message = 'Level id not found';
                    return response(array('status' => 'error', 'status_code' => '505', 'error' => $message), 505);
                } else {
                    Levels::where('id', $levelId)->delete();
                    $message = 'Level deleted successfully';
                    return response(array('status' => 'success', 'status_code' => '200', 'success' => $message), 200);
                }
            }
        } catch (Exception $ex) {
            //dd($ex->getMessage());
            return response(array('status' => 'error', 'status_code' => '505', 'error' => $ex->getMessage()), 505);
        }
    }

    public function DeleteSubLevel(Request $request) {
        //{"sublevel_id":"11"}

        try {
            $rules = array('sublevel_id' => 'required|numeric');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failedRules = $validator->getMessageBag()->toArray();
                $errorMsg = [];
                if (isset($failedRules['sublevel_id'])) {
                    $errorMsg[] = $failedRules['sublevel_id'][0];
                }

                return response(array('status' => 'error', 'status_code' => '500', 'error' => implode(',', $errorMsg)), 500);
            } else {
                $SublevelId = $request->sublevel_id;
                $find_id = SubLevels::where('id',$SublevelId)->first();
                if(!$find_id) {
                    $message = 'Sub level id not found';
                    return response(array('status' => 'error', 'status_code' => '505', 'error' => $message), 505);
                } else {
                    SubLevels::where('id', $SublevelId)->delete();
                    $message = 'Sub level deleted successfully';
                    return response(array('status' => 'success', 'status_code' => '200', 'success' => $message), 200);
                }
                return response(array('status' => 'success', 'status_code' => '200', 'success' => $message), 200);
            }
        } catch (Exception $ex) {
            
            return response(array('status' => 'error', 'status_code' => '505', 'error' => $ex->getMessage()), 505);
        }
    }

}
