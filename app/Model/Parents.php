<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model {
    
    /*
     * @created : April 01, 2019
     * @author  : Nadeem
     * @access  : public
     * @Purpose : This function is used for the avatar of users.
     * @params  : None
     * @return  : None
     */

    public static function getAvtars($user = array()) {
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
