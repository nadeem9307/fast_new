<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Semester extends Model {

    public $table = "semesters";

    /*
     * @created : Feb 20, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is use to get All semester which are call from SemesterController.
     * @params  : None
     * @return  : None
     */

    public static function allSemester($request, $id) {
        $perpage = $request->datatable['pagination']['perpage'];
        $page = $request->datatable['pagination']['page'];
        $draw = (isset($request->datatable['pagination']['draw']) && ($request->datatable['pagination']['draw'] != "") ? $request->datatable['pagination']['draw'] : '1');
        $sem_name = (isset($request->datatable['query']['sem_name']) && ($request->datatable['query']['sem_name'] != "") ? $request->datatable['query']['sem_name'] : '');
        $status = (isset($request['query']['status']) && ($request['query']['status'] != "") ? $request['query']['status'] : '1');
        $level = (isset($request['query']['level_id']) && ($request['query']['level_id'] != "") ? $request['query']['level_id'] : '');
        $sublevel = (isset($request['query']['sublevel_id']) && ($request['query']['sublevel_id'] != "") ? $request['query']['sublevel_id'] : '');
        $sortByField = (isset($request->datatable['sort']['field']) && ($request->datatable['sort']['field'] != "") ? $request->datatable['sort']['field'] : '');
        $orderBy = (isset($request->datatable['sort']['sort']) && ($request->datatable['sort']['sort'] != "") ? $request->datatable['sort']['sort'] : '');
        if ($page == '1') {
            $offset = 0;
        } else if ($page) {
            $offset = ($page - 1) * $perpage;
        } else {
            $offset = 0;
        }
        DB::statement(DB::raw('set @rownumber=' . $offset . ''));
        $semester = DB::table('semesters')
                ->join('sublevels', 'semesters.sublevel_id', '=', 'sublevels.id')
                ->select(DB::Raw('@rownumber:=@rownumber+1 as S_No'), 'semesters.id', 'semesters.sublevel_id', 'semesters.sem_name', 'semesters.status', 'sublevels.sublevel_name')
                ->where('semesters.status', $status)
                ->where('sublevel_id', $id);


        if ($status != '') {
            $semester = $semester->where('semesters.status', $status);
        }
        if ($sublevel != '') {
            $semester = $semester->where('sublevel_id', 'like', $sublevel . '%');
        }
        if ($sortByField != '' && $orderBy != '') {
            $semester = $semester->orderBy($sortByField, $orderBy);
        } else {
            $semester = $semester->orderBy('id', 'ASC');
        }
        $total = $semester->count();
        $meta = ['perpage' => $perpage, 'total' => $total, 'page' => $page];
        $semester = $semester->get();
        return $semester;
    }

    /*
     * @created : Feb 14, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to save semester details.
     * @params  : none
     * @return  : users
     */

    public static function Savesemester($request) {
        $id = $request->id;
        if ($id) {
            $addsemester = Semester::find($id);
            $check_name = Semester::where(['sem_name' => $request->semester_name])
                            ->where(function($query) use ($id) {
                                if (isset($id)) {
                                    $query->where('id', '<>', $id);
                                }
                            })->exists();
            if ($check_name) {
                return array('status' => 'error', 'message' => "Semester already exists.");
            }
//           
            $addsemester->sublevel_id = $request->sublevels;
            $addsemester->sem_name = $request->semester_name;
            $addsemester->priority = $request->priority_order;
        } else {
            $check = Semester::where(['sem_name' => $request->semester_name])
                            ->where(function($query) use ($id) {
                                if (isset($id)) {
                                    $query->where('id', '<>', $id);
                                }
                            })->exists();
            if ($check) {
                return array('status' => 'error', 'message' => "Semester already exists.");
            }
//           
            $addsemester = new Semester();
            $addsemester->sublevel_id = $request->sublevels;
            $addsemester->sem_name = $request->semester_name;
            $addsemester->priority = $request->priority_order;
            $addsemester->status = '1';
        }
        return $addsemester;
    }

    /*
     * @created : Feb 14, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to change user status active to archive.
     * @params  : none
     * @return  : none
     */

    public static function ArchiveStatus($request) {
        if ($request->id) {
            $sem_detail = Semester::where(['id' => $request->id])->first();
            $semester = Semester::find($sem_detail->id);
            if ($sem_detail->status == 1) {
                $semester->status = 2;
            } else {
                $semester->status = 1;
            }
            if ($semester->save()) {
                return "success";
            }
        }
        return (json_encode(array('status' => 'error', 'message' => "No Such Record is Found!!!")));
    }

}
