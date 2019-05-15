<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use DB;

class Levels extends Model {

    public $table = "levels";

    /*
     * @created : Feb 20, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get level list.
     * @params  : none
     * @return  : users
     */

    public static function getlevels() {
        $levels = Levels::orderBy('priority', 'asc')->where('status', 1)->get()->toArray();
        return $levels;
    }

    /*
     * @created : Feb 20, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get sub level list.
     * @params  : none
     * @return  : users
     */

    public static function getsublevels() {
        $sublevels = SubLevels::orderBy('priority', 'asc')->where('status', 1)->get()->toArray();
        return $sublevels;
    }

    /*
     * @created : Feb 14, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get All semester which are call from SemesterController.
     * @params  : None
     * @return  : None
     */

    public static function allLevels($request) {
        $perpage = $request->datatable['pagination']['perpage'];
        $page = $request->datatable['pagination']['page'];
        $draw = (isset($request->datatable['pagination']['draw']) && ($request->datatable['pagination']['draw'] != "") ? $request->datatable['pagination']['draw'] : '1');
//        $sem_name = (isset($request->datatable['query']['sem_name']) && ($request->datatable['query']['sem_name'] != "") ? $request->datatable['query']['sem_name'] : '');
        $status = (isset($request['query']['status']) && ($request['query']['status'] != "") ? $request['query']['status'] : '1');
//        $level = (isset($request['query']['level_id']) && ($request['query']['level_id'] != "") ? $request['query']['level_id'] : '');
//        $sublevel = (isset($request['query']['sublevel_id']) && ($request['query']['sublevel_id'] != "") ? $request['query']['sublevel_id'] : '');
//        $sortByField = (isset($request->datatable['sort']['field']) && ($request->datatable['sort']['field'] != "") ? $request->datatable['sort']['field'] : '');
        $orderBy = (isset($request->datatable['sort']['sort']) && ($request->datatable['sort']['sort'] != "") ? $request->datatable['sort']['sort'] : '');
        if ($page == '1') {
            $offset = 0;
        } else if ($page) {
            $offset = ($page - 1) * $perpage;
        } else {
            $offset = 0;
        }
        DB::statement(DB::raw('set @rownumber=' . $offset . ''));
        $levels = Levels::select(DB::Raw('@rownumber:=@rownumber+1 as S_No'), 'id', 'level_name', 'priority', 'min_age', 'max_age', 'status')
                ->where('status', $status);

        $total = $levels->count();
        $levels = $levels->get();
        return $levels;
    }

    /*
     * @created : Feb 14, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is used to get range avatars by id.
     * @params  : None
     * @return  : None
     */

    public static function GetRangeAvatar($request) {
        if ($request->filepath != '') {
            $levels = OverAllRange::where('id', $request->id)->first();
            if ($request->filepath == 'pmale') {
                $colum = "parent_male_avatar";
                $avatar = OverAllRange::select($colum)->where('id', $request->id)->first();
                if ($avatar) {
                    $array = json_decode($avatar->parent_male_avatar);
                    if (!empty($array)) {
                        $indexCompleted = array_search($request->img_name, $array);
                        unset($array[$indexCompleted]);
                        $levels->parent_male_avatar = json_encode(array_values($array));
                    } else {
                        $levels->parent_male_avatar = '';
                    }



                    /* -- end coding of image file -- */
                    if ($levels->save()) {
                        Storage::delete('app/levelavatar/' . "$request->filepath" . '/' . $request->img_name);
                        return true;
                    } else {
                        return false;
                    }
                }
            } else if ($request->filepath == 'pfemale') {
                $colum = "parent_female_avatar";
                $avatar = OverAllRange::select($colum)->where('id', $request->id)->first();
                if ($avatar) {
                    $array = json_decode($avatar->parent_female_avatar, true);
                    if (!empty($array)) {
                        $indexCompleted = array_search($request->img_name, $array);
                        unset($array[$indexCompleted]);
                        $levels->parent_female_avatar = json_encode(array_values($array));
                    } else {
                        $levels->parent_female_avatar = '';
                    }
                    /* -- end coding of image file -- */
                    if ($levels->save()) {
                        Storage::delete('app/levelavatar/' . "$request->filepath" . '/' . $request->img_name);
                        return true;
                    } else {
                        return false;
                    }
                }
            } else if ($request->filepath == 'cmale') {
                $colum = "child_male_avatar";
                $avatar = OverAllRange::select($colum)->where('id', $request->id)->first();
                if ($avatar) {

                    $array = json_decode($avatar->child_male_avatar, true);
                    if (!empty($array)) {
                        $indexCompleted = array_search($request->img_name, $array);
                        unset($array[$indexCompleted]);
                        $levels->child_male_avatar = json_encode(array_values($array));
                    } else {
                        $levels->child_male_avatar = '';
                    }
                    /* -- end coding of image file -- */
                    if ($levels->save()) {
                        Storage::delete('app/levelavatar/' . "$request->filepath" . '/' . $request->img_name);
                        return true;
                    } else {
                        return false;
                    }
                }
            } else if ($request->filepath == 'cfemale') {
                $colum = "child_female_avatar";
                $avatar = OverAllRange::select($colum)->where('id', $request->id)->first();
                if ($avatar) {
                   
                    $array = json_decode($avatar->child_female_avatar, true);
                     if (!empty($array)) {
                    $indexCompleted = array_search($request->img_name, $array);
                    unset($array[$indexCompleted]);
                    $levels->child_female_avatar = json_encode(array_values($array));
                     }else{
                         $levels->child_female_avatar = '';
                     }
                    /* -- end coding of image file -- */
                    if ($levels->save()) {
                        Storage::delete('app/levelavatar/' . "$request->filepath" . '/' . $request->img_name);
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
    }

   

}
