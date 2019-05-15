<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Levels;
use App\Model\OverAllRange;
use App\Model\SubLevels;
use App\Helpers\Helper;
use Validator;
use DB;
use Response;
use Exception;


class LevelsController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Levels Controller
      |--------------------------------------------------------------------------
      |
      | Here is we can manage Levels.
      |
      |
     */

    /*
     * @created : Feb 20, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to view index page of Levels.
     * @params  : None
     * @return  : None
     */

    public function index() {
        try {
            $level = Levels::getlevels();
            $sublevel = Levels::getsublevels();
            return view('admin.levels.index', compact('level', 'sublevel'));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());

            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Feb 20, 2019
     * @author  : Nadeem    
     * @access  : public
     * @Purpose : This function is use to listing of all levels.
     * @params  : None
     * @return  : None
     */

    public function getAllLevels(Request $request) {
        try {
            $levels = Levels::allLevels($request);
            return Response::json(array('data' => $levels));
        } catch (\Illuminate\Database\QueryException $ex) {

            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());

            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

    /*
     * @created : Feb 21, 2019
     * @author  : Nitish   
     * @access  : public
     * @Purpose : This function is use to store avatar for parent and child male and female.
     * @params  : None
     * @return  : None
     */

    public function storeAvatar(Request $request) {
        if ($request->ajax()) {
//            print_r($request->all());
//            die;
            try {
                $rules = array(
                    'upload_avtars_pmale' => 'max:2048',
                    'upload_avtars_pfemale' => 'max:2048',
                    'upload_avtars_cmale' => 'max:2048',
                    'upload_avtars_cfemale' => 'max:2048',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['upload_avtars_pmale']))
                        $errorMsg = $failedRules['upload_avtars_pmale'][0] . "\n";
                    if (isset($failedRules['upload_avtars_pfemale']))
                        $errorMsg = $failedRules['upload_avtars_pfemale'][0] . "\n";
                    if (isset($failedRules['upload_avtars_cmale']))
                        $errorMsg = $failedRules['upload_avtars_cmale'][0] . "\n";
                    if (isset($failedRules['upload_avtars_cfemale']))
                        $errorMsg = $failedRules['upload_avtars_cfemale'][0] . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                    //                    $count = Levels::getExistAvatar($request);
                } else {
                    $levels = OverAllRange::where('id', $request->mylevelid)->first();
                    /* -- start coding of image file -- */
                    $allowed = array('jpg', 'png', 'jpeg');
                    if ($request->upload_avtars_pmale != '' || !empty($request->upload_avtars_pmale)) {
                        if ($request->hasFile('upload_avtars_pmale')) {
                            $image_name_pmale = array();
                            foreach ($request->upload_avtars_pmale as $image) {
                                $filename_pmale = str_random(5) . "-" . date('his') . '.' . $image->getClientOriginalExtension();
                                $type_pmale = strtolower($image->getClientOriginalExtension());
                                if (!in_array($type_pmale, $allowed)) {
                                    return (json_encode(array('status' => 'error', 'message' => 'Please select only jpg,png,jpeg image type format only')));
                                }
                                $pmale = storage_path('app/levelavatar/pmale');
                                $image->move($pmale, $filename_pmale);
                                $image_name_pmale[] = $filename_pmale;
                            }
                            if (!empty($levels->parent_male_avatar)) {
                                $exist = json_decode($levels->parent_male_avatar, true);
                                $image_name_pmale = array_merge($exist, $image_name_pmale);
                               
                                $levels->parent_male_avatar = json_encode($image_name_pmale);
                            } else {
                                $levels->parent_male_avatar = json_encode($image_name_pmale);
                            }
                        }
                    }
                    if ($request->upload_avtars_pfemale != '' || !empty($request->upload_avtars_pfemale)) {
                        if ($request->hasFile('upload_avtars_pfemale')) {
                            $image_name_pfemale = array();
                            foreach ($request->upload_avtars_pfemale as $image2) {

                                $filename_pfemale = str_random(5) . "-" . date('his') . '.' . $image2->getClientOriginalExtension();
                                $type_pfemale = strtolower($image2->getClientOriginalExtension());
                                if (!in_array($type_pfemale, $allowed)) {
                                    return (json_encode(array('status' => 'error', 'message' => 'Please select only jpg,png,jpeg image type format only')));
                                }
                                $pfemale = storage_path('app/levelavatar/pfemale');
                                $image2->move($pfemale, $filename_pfemale);
                                $image_name_pfemale[] = $filename_pfemale;
                            }
                            if (!empty($levels->parent_female_avatar)) {
                                $exist = json_decode($levels->parent_female_avatar, true);
                                $image_name_pfemale = array_merge($exist, $image_name_pfemale);
                               
                                $levels->parent_female_avatar = json_encode($image_name_pfemale);
                            } else {
                                $levels->parent_female_avatar = json_encode($image_name_pfemale);
                            }
                        }
                    }
                    if ($request->upload_avtars_cmale != '' || !empty($request->upload_avtars_cmale)) {

                        if ($request->hasFile('upload_avtars_cmale')) {
                            $image_name_cmale = array();
                            foreach ($request->upload_avtars_cmale as $image3) {
                                $filename_cmale = str_random(5) . "-" . date('his') . '.' . $image3->getClientOriginalExtension();
                                $type_cmale = strtolower($image3->getClientOriginalExtension());
                                if (!in_array($type_cmale, $allowed)) {
                                    return (json_encode(array('status' => 'error', 'message' => 'Please select only jpg,png,jpeg image type format only')));
                                }
                                $cmale = storage_path('app/levelavatar/cmale');
                                $image3->move($cmale, $filename_cmale);
                                $image_name_cmale[] = $filename_cmale;
                            }
                            if (!empty($levels->child_male_avatar)) {
                                $exist = json_decode($levels->child_male_avatar, true);
                                $image_name_cmale = array_merge($exist, $image_name_cmale);
                                $levels->child_male_avatar = json_encode($image_name_cmale);
                                
                            } else {
                                $levels->child_male_avatar = json_encode($image_name_cmale);
                            }
                        }
                    }
                    if ($request->upload_avtars_cfemale != '' || !empty($request->upload_avtars_cfemale)) {

                        if ($request->hasFile('upload_avtars_cfemale')) {
                            $image_name_cfemale = array();
                            foreach ($request->upload_avtars_cfemale as $image4) {
                                $filename_cfemale = str_random(5) . "-" . date('his') . '.' . $image4->getClientOriginalExtension();
                                $type_cfemale = strtolower($image4->getClientOriginalExtension());
                                if (!in_array($type_cfemale, $allowed)) {
                                    return (json_encode(array('status' => 'error', 'message' => 'Please select only jpg,png,jpeg image type format only')));
                                }
                                $cfemale = storage_path('app/levelavatar/cfemale');
                                $image4->move($cfemale, $filename_cfemale);
                                $image_name_cfemale[] = $filename_cfemale;
                            }
                            if (!empty($levels->child_female_avatar)) {
                                $exist = json_decode($levels->child_female_avatar, true);
                                $image_name_cfemale = array_merge($exist, $image_name_cfemale);
                                $levels->child_female_avatar = json_encode($image_name_cfemale);
                            } else {
                                $levels->child_female_avatar = json_encode($image_name_cfemale);
                            }
                        }
                    }

                    //                        print_r($image_name_pfemale);
                }
                /* -- end coding of image file -- */
                if ($levels->save()) {
                    return (json_encode(array('status' => 'success', 'message' => sprintf('Update Avatar successfully'))));
                } else {
                    return (json_encode(array('status' => 'error', 'message' => sprintf('Failed to update Avatar'))));
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

    /*
     * @created : Feb 21, 2019
     * @author  : Nitish   
     * @access  : public
     * @Purpose : This function is use to get avatar for parent and child male and female.
     * @params  : None
     * @return  : None
     */

    public function getAvatar(Request $request) {
        try {
            if ($request->ajax()) {
                $status = "success";
                $avtars = OverAllRange::select('parent_male_avatar', 'parent_female_avatar', 'child_male_avatar', 'child_female_avatar')->where('id', $request->id)->first();
                if ($avtars) {
                    return (json_encode(array('status' => $status, 'message' => $avtars)));
                }
                return (json_encode(array('status' => 'error', 'message' => 'No Data found.')));
            }
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
     * @created : Feb 21, 2019
     * @author  : Nitish   
     * @access  : public
     * @Purpose : This function is use to delete avatar for parent and child male and female.
     * @params  : None
     * @return  : None
     */

    public function DeleteAvatar(Request $request) {
        if ($request->ajax()) {
            try {
                $status = "success";
                $avtars = Levels::GetRangeAvatar($request);
                if ($avtars != false) {
                    return (json_encode(array('status' => $status, 'message' => 'Avatar deleted successfully.')));
                }
                return (json_encode(array('status' => 'error', 'message' => 'No Data found.')));
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
     * @created : April 05, 2019
     * @author  : Nitish Kumar
     * @access  : public
     * @Purpose : This function is use to save age range level
     * @params  : None
     * @return  : None
     */

    public function store_age_range(request $request) {
        if ($request->ajax()) {
            try {
                $rules = array(
                    'min_age' => 'required',
                    'max_age' => 'required',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    $failedRules = $validator->getMessageBag()->toArray();
                    $errorMsg = "";
                    if (isset($failedRules['min_age']))
                        $errorMsg = $failedRules['min_age'][0] . "\n";
                    if (isset($failedRules['max_age']))
                        $errorMsg = $failedRules['max_age'][0] . "\n";
                    return (json_encode(array('status' => 'error', 'message' => $errorMsg . "\n")));
                    /* --------------------- end range validation ------------------- */
                } else {
                    $manage_age_range = array();
                    if ($request->id) {
                        $check = DB::select("SELECT * FROM `fi_levels` WHERE ((min_age = $request->min_age AND max_age= $request->max_age) OR (min_age = $request->min_age AND max_age = $request->max_age) OR ($request->min_age BETWEEN min_age and max_age) OR ($request->max_age BETWEEN min_age and max_age)) AND id != $request->id ORDER BY `max_age` ASC");
                        if ($check) {
                            return (json_encode(array('status' => 'error', 'message' => 'Age Range already exist.')));
                        }
                        $age_range_level = Levels::find($request->id);
                        $age_range_level->min_age = $request->min_age;
                        $age_range_level->max_age = $request->max_age;
                        if ($age_range_level->save()) {
                            return (json_encode(array('status' => 'success', 'message' => 'Save age range level')));
                        } else {
                            return (json_encode(array('status' => 'error', 'message' => 'Failed to add range level')));
                        }
                    } else {
                        return (json_encode(array('status' => 'error', 'message' => 'Something wrong, please check levels')));
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

    /*
     * @created : April 05, 2019
     * @author  : Nitish Kumar
     * @access  : public
     * @Purpose : This function is use to get all age range
     * @params  : None
     * @return  : None
     */

    public function getage_Range(request $request) {
        try {
            $levels = Levels::find($request->id);
            return (json_encode(array('status' => 'success', 'message' => $levels)));
        } catch (\Illuminate\Database\QueryException $ex) {

            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

}
