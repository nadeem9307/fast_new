<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ParentOverAllInterpretation extends Model {

    public $table = "parent_over_all_interpretations";

    /*
     * @created : Jan 23, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get Interpretation.
     * @params  : none
     * @return  : Interpretation data
     */

    public static function GetInterpretationRange($overallrange_id ='') {
        try {
            $categories = ParentCategory::select('category_name', 'id as category_id')->orderBy('id', 'ASC')->get()->toArray();
            $ranges = OverAllRange::select('id', 'min_range', 'max_range')->get()->toArray();
            $overall_ids = ParentOverAllInterpretation::select('individual_range_ids')->where('overall_range', $overallrange_id)->get()->toArray();
            return compact('categories', 'ranges', 'overall_ids');
        } catch (\Illuminate\Database\QueryException $ex) {
            return $ex;
        }
    }

    /*
     * @created : Jan 27, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save over all Interpretation.
     * @params  : none
     * @return  : Interpretation data
     */

    public static function SaveOverAllInterpretation($request) {
        $id = $request->id;
        $category_id = $request->category_id;
        /* --------------------- check if  Over all Interpretation already exist ------------------- */
        $check = ParentOverAllInterpretation::where('category_ids', "'$request->category_id'")
                ->where('individual_range_ids', "'$request->range_id'")
                ->where('overall_range', "'$request->overall_range'");
        if (isset($id)) {
            $check->where(function($query) use ($id) {
                $query->where('id', '<>', $id);
            });
        }
        $check = $check->exists();
        /* --------------------- Over all Interpretation already exist ------------------- */
        if ($check) {
            return false;
        } else {
            if ($request->id) {
                /* ---------------------  update Over all Interpretation------------------- */
                $interp = ParentOverAllInterpretation::find($request->id);
            } else {
                /* --------------------- if new Over all Interpretation ------------------- */
                $interp = new ParentOverAllInterpretation();
            }
            foreach ($request->interpretation as $key => $val) {
                $inter[$key] = htmlentities($val);
            }
            $interp->category_ids = $request->category_id;
            $interp->individual_range_ids = $request->range_id;
            $interp->overall_range = $request->overall_range;
            $interp->interpretation = json_encode($inter);
            return $interp->save();
        }
    }

    /*
     * @created : Jan 22, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to Edit Interpretation.
     * @params  : none
     * @return  : Interpretation data
     */

    public static function EditOverallInterpretation($request) {
        $id = isset($request->range_ids) ? $request->range_ids : false;
        if ($id) {
            return ParentOverAllInterpretation::where("category_ids", $request->cat_ids)->where('individual_range_ids', $request->range_ids)->where('overall_range', $request->overall_range)->select('*')->first();
        }
        return false;
    }

}
