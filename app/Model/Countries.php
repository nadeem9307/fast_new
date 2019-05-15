<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Countries extends Model {
    /*
      |--------------------------------------------------------------------------
      | Countries Model
      |--------------------------------------------------------------------------
      |
      | Here is we can make a function for indexing, add, edit, activate and deactivate
      | which we can call in the CountriesController.

     */

    public $table = "countries";
    protected $fillable = ['short_code', 'country_name', 'country_code'];

    /*
     * @created : January 03, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to add new country which are call from CountriesController.
     * @params  : None
     * @return  : None
     */

    /* public static function saveCountry($request) {

      $id = $request->id;
      $check = Countries::where(['country_name' => $request->country_name, 'short_code' => $request->short_code, 'country_code' => $request->country_code])
      ->where(function($query) use ($id) {
      if (isset($id)) {
      $query->where('id', '<>', $id);
      }
      })->exists();

      if ($check) {
      return (array('status' => 'error', 'message' => "Country already exist."));
      }
      if ($request->id) {
      $add_country = Countries::find($request->id);
      } else {
      $add_country = new Countries();
      }
      $add_country->country_name = $request->country_name;
      $add_country->short_code = $request->short_code;
      $add_country->country_code = $request->country_code;

      return $add_country;
      }


      /*
     * @created : January 03, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get All countries which are call from CountriesController.
     * @params  : None
     * @return  : None
     */

    public static function allCountry($request) {
        $perpage = $request['pagination']['perpage'];
        $page = $request['pagination']['page'];
        $draw = (isset($request['pagination']['draw']) && ($request['pagination']['draw'] != "") ? $request['pagination']['draw'] : '1');
        $country_name = (isset($request['query']['country_name']) && ($request['query']['country_name'] != "") ? $request['query']['country_name'] : '');
        $status = (isset($request['query']['status']) && ($request['query']['status'] != "") ? $request['query']['status'] : '');
        $sortByField = (isset($request['sort']['field']) && ($request['sort']['field'] != "") ? $request['sort']['field'] : '');
       $orderBy = (isset($request['sort']['sort']) && ($request['sort']['sort'] != "") ? $request['sort']['sort'] : '');
        
        if ($page == '1') {
            $offset = 0;
        } else if ($page) {
            $offset = ($page - 1) * $perpage;
        } else {
            $offset = 0;
        }
        $countries = new Countries();
        $countries = $countries->select('id', 'short_code', 'country_name', 'country_code', 'status');
        if ($country_name != '') {
            $countries = $countries->where('country_name', 'like', $country_name . '%');
        }
        if ($status != '') {
            $countries = $countries->where('status', $status);
        }
        if ($sortByField != '' && $orderBy != '') {
            $countries = $countries->orderBy($sortByField, $orderBy);
           
        } else {
            $countries = $countries->orderBy('country_name', 'ASC');
        }
       
        DB::statement(DB::raw('set @rownumber=' . $offset . ''));
        $total = $countries->count();
        $countries = $countries->select('id', 'short_code', 'country_name', 'country_code', 'status', DB::raw('@rownumber:=@rownumber+1 as S_No'));
        $meta = ['perpage' => $perpage, 'total' => $total, 'page' => $page];
        $total = $countries->count();
        $countries = $countries->get();
//         print_r($countries);
//        die;
        return $countries;
    }

    /*
     * @created : January 03, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to edit country which are call from CountriesController.
     * @params  : None
     * @return  : None
     */

    public static function editcountry($request) {
        $result = Countries::select('short_code', 'country_name', 'country_code', 'id')->where(['id' => $request->id])->first();
        return $result;
    }

}
