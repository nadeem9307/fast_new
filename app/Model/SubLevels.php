<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class SubLevels extends Model {

    public $table = "sublevels";

    /*
     * @created : Feb 14, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to get All semester which are call from SemesterController.
     * @params  : None
     * @return  : None
     */

    public static function allSubLevels($request) {
        $perpage = $request->datatable['pagination']['perpage'];
        $page = $request->datatable['pagination']['page'];
        $draw = (isset($request->datatable['pagination']['draw']) && ($request->datatable['pagination']['draw'] != "") ? $request->datatable['pagination']['draw'] : '1');
        $status = (isset($request['query']['status']) && ($request['query']['status'] != "") ? $request['query']['status'] : '1');
        $orderBy = (isset($request->datatable['sort']['sort']) && ($request->datatable['sort']['sort'] != "") ? $request->datatable['sort']['sort'] : '');
        if ($page == '1') {
            $offset = 0;
        } else if ($page) {
            $offset = ($page - 1) * $perpage;
        } else {
            $offset = 0;
        }
        DB::statement(DB::raw('set @rownumber=' . $offset . ''));
        $levels = SubLevels::select(DB::Raw('@rownumber:=@rownumber+1 as S_No'), 'id', 'sublevel_name', 'priority', 'status')
                ->where('status', $status);

        $total = $levels->count();
        $levels = $levels->get();
        return $levels;
    }

}
