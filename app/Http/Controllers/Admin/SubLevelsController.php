<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Levels;
use App\Model\SubLevels;
use App\Helpers\Helper;
use Response;
use Exception;

class SubLevelsController extends Controller {
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
            return view('admin.sublevels.index', compact('level', 'sublevel'));
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

    public function getAllSubLevels(Request $request) {
        try {
            $sublevels = SubLevels::allSubLevels($request);
            return Response::json(array('data' => $sublevels));
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

}
