<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ParentCategory;

class ParentInterpretation extends Model {

    public $table = "parent_category_wise_interpretation";

    /*
     * @created : Jan 21, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get category list.
     * @params  : none
     * @return  : users
     */

    public static function getCategory() {
        $categories = DB::table('parent_categories')->get();
        return $categories;
    }

    /*
     * @created : Jan 21, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to display all  interpretation name.
     * @params  : 4
     * @return  : category data
     */

//    public static function getInterByCategory($perpage, $page, $offset, $draw, $cat_id) {
//        DB::statement(DB::raw('set @rownumber=' . $offset . ''));
//        $category = DB::table('interpretations')
//                ->join('categories', 'interpretations.category_id', '=', 'categories.id')
//                ->select(DB::Raw('@rownumber:=@rownumber+1 as S_No'), 'interpretations.id', 'interpretations.interpretation', 'interpretations.min_range', 'interpretations.max_range', 'interpretations.status', 'categories.id as category_id', 'categories.category_name')
//                ->where('categories.id', $cat_id);
//        $category = $category->get();
//        $total = $category->count();
//        $meta = ['draw' => $draw, 'perpage' => $perpage, 'total' => $total, 'page' => $page];
//        return $category;
//    }

    /*
     * @created : Jan 22, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save  all interpretation data.
     * @params  : none
     * @return  : users
     */

    public static function SaveInterpretation($request) {
        $id = $request->id;
        $category_id = $request->category_id;

        /* --------------------- check if Interpretation already exist ------------------- */
        $check = Interpretation::where('max_range', '>=', $request->input('min_range'))
                ->Where('max_range', '>=', $request->input('max_range'))
                ->where('category_id', $request->category_id)
//                        ->where(function($query) use ($id) {
//                            if (isset($id)) {
//                                $query->where('id', '<>', $id);
//                            }
//                        })
                ->exists();

        /* --------------------- end  Interpretation already exist validation ------------------- */
        if ($check) {
            return array('status' => 'error', 'message' => " already exist.");
        }
        if ($request->id) {
            /* --------------------- Interpretation update ------------------- */
            $interp = Interpretation::find($request->id);
        } else {
            /* --------------------- if new Interpretation ------------------- */
            $interp = new Interpretation();
        }
         foreach ($request->interpretation as $key => $val) {
           $inter[$key] = htmlentities($val);
        }
        $interp->category_id = $request->category_id;
        $interp->min_range = $request->min_range;
        $interp->max_range = $request->max_range;
        $interp->interpretation = json_encode($inter);

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

    public static function EditInterpretation($request) {
        $id = $request->range_id;
        if ($id != '') {
            return ParentInterpretation::where("range_id", $request->range_id)->where('category_id', $request->category_id)->select('*')->first();
        } else {
            return false;
        }
    }

    /*
     * @created : Jan 23, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get Interpretation.
     * @params  : none
     * @return  : Interpretation data
     */

    public static function GetInterpretationRange($category_id) {
        try {
            $cat = ParentCategory::where('id', $category_id)->first();
            if ($cat) {
                $data = OverAllRange::select('id', 'min_range', 'max_range')->get()->toArray();
                $cate_data = ParentInterpretation::select('range_id')->where('category_id', $category_id)->get()->toArray();
                return compact('data', 'cate_data', 'cat');
            } else {
                abort(404);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return $ex;
        }
    }

    /*
     * @created : Jan 23, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save category Interpretation.
     * @params  : none
     * @return  : none
     */

    public static function SaveCatInterpretation($request) {
        $id = $request->id;
        $category_id = $request->category_id;
        /* --------------------- check if Interpretation already exist ------------------- */
        $check = ParentInterpretation::where('range_id', '=', $request->input('range_id'))
                        ->where('category_id', '=', $request->input('category_id'))
                        ->where(function($query) use ($id) {
                            if (isset($id)) {
                                $query->where('id', '<>', $id);
                            }
                        })->exists();

        /* --------------------- end  Interpretation already exist ------------------- */
        if ($check) {
            return array('status' => 'error', 'message' => " already exist.");
        }
        if ($request->id) {
            /* --------------------- Interpretation update ------------------- */
            $interp = ParentInterpretation::find($request->id);
        } else {
            /* --------------------- if new Interpretation ------------------- */
            $interp = new ParentInterpretation();
        }
//        print_r($request->interpretation);
//        die;
        foreach ($request->interpretation as $key => $val) {
           $inter[$key] = htmlentities($val);
        }
        $interp->category_id = $request->category_id;
        $interp->range_id = $request->range_id;
        $interp->interpretation = json_encode($inter);

        return $interp;
    }

  

}
