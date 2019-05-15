<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

use App\Model\Settings;
use Response;
use App\Model\TestResult;
use App\Model\SubLevels;
use App\Model\OverAllRange;
use App\Helpers\Helper;
use Carbon\Carbon;
use DB;
use Request;

class Helper {

    public static function getRetakeTestLimit($user_id) {
        $currentMonth = date('m');
        $test = TestResult::where('user_id', $user_id)->whereMonth('created_at', Carbon::now()->month)->get();
        $total_given_test = count($test);

        $setting = Settings::where('user_id', 1)->first();
        if ($setting) {
            $test_limit = json_decode($setting->settings_json, true);
            if ($total_given_test <= $test_limit['retake_test_limit']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public static function getUserFastScore($user_id) {
        $score_data = DB::table('user_fast_score')->select(DB::raw('ROUND(SUM(fast_score)) as fast_score'))->where('user_id', $user_id)->first();
        if ($score_data->fast_score != '') {
            return $score_data->fast_score;
        } else {
            return '0';
        }
    }

    public static function getsubLevelId($name) {
        $sub_name = SubLevels::select('id')->where('sublevel_name', $name)->first();
        if ($sub_name) {
            return $sub_name->id;
        } else {
            return "";
        }
    }

    /*
     * @created : April 09, 2019
     * @author  : Nitish
     * @access  : public
     * @Purpose : This function is use to store the fatal query.
     * @params  : None
     * @return  : None
     */

    public static function store_error_log($message, $line_no, $file_name) {
        $request = request();
        $route_url = url()->full();
        $method = $request->method();
        $request_data = $request->all();
        DB::table('error_log')->insert(['route_url' => $route_url, 'error_file' => $file_name, 'method' => $method , 'request_data' => json_encode([$request_data]), 'description' => $message, 'line_of_code' => $line_no]);
    }
    
    
      public static function getUserAvtars($user = array()) {
        $fast_score = $user->fast_score;
        $images = array();
        $range_id = OverAllRange::where('min_range', '<=', $fast_score)->where('max_range', '>', $fast_score)->orwhere('max_range', '=', $fast_score)->select('id')->first();
        if ($user->user_type == '2' && $user->gender == '1') {
            $avtars = OverAllRange::where('id', $range_id->id)->select('parent_male_avatar')->first();
            $images['images'] = json_decode($avtars->parent_male_avatar, true);
            $images['dir']['subdir'] = 'pmale';
        } else if ($user->user_type == '2' && $user->gender == '2') {
            $avtars = OverAllRange::where('id', $range_id->id)->select('parent_female_avatar')->first();
            $images['images'] = json_decode($avtars->parent_female_avatar, true);
            $images['dir']['subdir'] = 'pfemale';
        } else if ($user->user_type == '3' && $user->gender == '1') {
            $avtars = OverAllRange::where('id', $range_id->id)->select('child_male_avatar')->first();
            $images['images'] = json_decode($avtars->child_male_avatar, true);
            $images['dir']['subdir'] = 'cmale';
        } else if ($user->user_type == '3' && $user->gender == '2') {
            $avtars = OverAllRange::where('id', $range_id->id)->select('child_female_avatar')->first();
            $images['images'] = json_decode($avtars->child_female_avatar, true);
            $images['dir']['subdir'] = 'cfemale';
        } else {
            return false;
        }
        return $images;
    }

}
