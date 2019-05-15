<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model {

    protected $fillable = [
        'category_name'
    ];

    /* --------- Save and update Category here----------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to save category name.
     * @params  : None
     * @return  : none
     */

    public static function SaveCategory($request) {
        $id = $request->id;
        /* --------------------- check if Category Name already exist ------------------- */
        $check = Category::where('category_name', '=', $request->category)
                    ->where('level_id', '=', $request->levels)
                        ->where(function($query) use ($id) {
                            if (isset($id)) {
                                $query->where('id', '<>', $id);
                            }
                        })->exists();
        /* --------------------- end  Category Name already exist ------------------- */
                        
        if ($check) {
            return false;
        }
        if ($request->id) {
            /* --------------------- Category Name update ------------------- */
            $category = Category::find($request->id);
        } else {
            /* --------------------- if new Category Name ------------------- */
            $category = new Category();
        }
        $category->category_name = $request->category;
        $category->level_id = $request->levels;
        return $category;
    }

    /* -------- Display All Categories list in datatable----------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to display all  category name.
     * @params  : 4
     * @return  : category data
     */

    public static function getCategory($perpage, $page, $offset, $draw,$search) {

        DB::statement(DB::raw('set @row:=' . $offset . ''));
        $cat_data = Category::selectRaw('*, @row:=@row+1 as S_No');
        $total = $cat_data->count();
         if ($search !== '') {
            $cat_data->where('category_name', 'like', $search . '%');
        }
        $cat_data = $cat_data->get();
        $meta = ['draw' => $draw, 'perpage' => $perpage, 'total' => $total, 'page' => $page];
        return $cat_data;
    }

    /* --------- Edit Category Data-------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to edit category name.
     * @params  : none
     * @return  : updated category
     */

    public static function EditCategory($request) {

        $id = $request->id;
        if ($id != '') {
            $category = Category::find($id);
            $input = $request->all();
            return $category;
        } else {
            return "error";
        }
    }

    /* ------------delete category here ------------ */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to delete category name.
     * @params  : none
     * @return  : none
     */

    public static function deleteCategory($request) {
        if ($request->id) {
            $category = Category::find($request->id);
            if ($category->delete()) {
                return "success";
            } else {
                return "error";
            }
        }
    }

    /* --------------- Change status of category ------------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public 
     * @Purpose : This function is use to activate status of a category name.
     * @params  : none
     * @return  : status
     */

    public static function ActivateDeactivateStatus($request) {
        try {
            if ($request->id) {
                $category_detail = Category::where(['id' => $request->id])->first();
                $category = Category::find($category_detail->id);
                if ($category_detail->status == 1) {
                    $category->status = 2;
                } else {
                    $category->status = 1;
                }
                if ($category->save()) {
                    return "success";
                }
            }
            return (json_encode(array('status' => 'error', 'message' => "No Such Record is Found!!!")));
        } catch (\Illuminate\Database\QueryException $ex) {
            return $ex;
        } catch (\Exception $e) {
            return $e;
        }
    }

}
