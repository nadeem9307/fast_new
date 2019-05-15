<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class OverAllRange extends Model {

    public $table = "overall_range";

    /*
     * @created : Jan 24, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to display overall ranges.
     * @params  : 4
     * @return  : category data
     */

    public static function getOverAllRanges($perpage, $page, $offset, $draw) {

        DB::statement(DB::raw('set @rownumber=' . $offset . ''));
        $overall = OverAllRange::select(DB::Raw('@rownumber:=@rownumber+1 as S_No'), 'id', 'min_range', 'max_range', 'status')->get();
        $total = $overall->count();
        $meta = ['draw' => $draw, 'perpage' => $perpage, 'total' => $total, 'page' => $page];
        return $overall;
    }

    /*
     * @created : Jan 22, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save  all interpretation data.
     * @params  : none
     * @return  : users
     */

    public static function SaveRange($request) {
        $id = $request->id;
        $min_range = $request->min_range;
        $max_range = $request->max_range;
        /* --------------------- check if Range already exist ------------------- */
        //SELECT * FROM `fi_overall_range` WHERE (min_range=12 AND max_range=42) OR (m_range=12 AND max_range=42) 
        // OR (12 BETWEEN min_range and max_range) OR (42 BETWEEN min_range and max_range)  ORDER BY `max_range` ASC
//        $check = DB::select("SELECT * FROM `fi_overall_range` WHERE (min_range=$min_range AND max_range=$max_range) OR (min_range=$min_range AND max_range=$max_range) 
//        OR ($min_range BETWEEN min_range and max_range) OR ($max_range BETWEEN min_range and max_range)  ORDER BY `max_range` ASC");
       $check_id = "";
         if (isset($id)) {
                    $check_id ="(id<>'$id') AND ";
                }
                 $check = DB::select("SELECT * FROM `fi_overall_range` WHERE $check_id  (($min_range BETWEEN min_range and max_range and $min_range !=max_range) OR ($max_range BETWEEN min_range and max_range and $max_range !=min_range)) ");
         

        /* --------------------- end  Range already exist ------------------- */
        if ($check) {
            return array('status' => 'error', 'message' => " already exist.");
        }
        if ($request->id) {
            /* --------------------- Range update ------------------- */
            $interp = OverAllRange::find($request->id);
        } else {
            /* --------------------- if new User ------------------- */
            $interp = new OverAllRange();
        }
        $interp->min_range = $request->min_range;
        $interp->max_range = $request->max_range;

        return $interp;
    }

    /*
     * @created : Jan 22, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to Edit Interpretation.
     * @params  : none
     * @return  : Interpretation data
     */

    public static function EditRange($request) {
        $id = $request->id;
        if ($id != '') {
            $range = OverAllRange::where("id", $id)->select('*')->first();
            return $range;
        } else {
            return false;
        }
    }

}