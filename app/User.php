<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Countries;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'country_id', 'user_type', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
     * @created : Jan 4, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get countries list.
     * @params  : none
     * @return  : users
     */

    public static function getCountries() {
        $countries = DB::table('countries')->get();
        return $countries;
    }

    /* --------- get users Data-------- */
    /*
     * @created : Jan 4, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get all users data.
     * @params  : none
     * @return  : users
     */

    public static function getAllUsers($request) {
        $perpage = $request['pagination']['perpage'];
        $page = $request['pagination']['page'];
        $draw = (isset($request['pagination']['draw']) && ($request['pagination']['draw'] != "") ? $request['pagination']['draw'] : '1');
        $status = (isset($request['query']['status']) && ($request['query']['status'] != "") ? $request['query']['status'] : '');
        $username = (isset($request['query']['username']) && ($request['query']['username'] != "") ? $request['query']['username'] : '');
        $user_type = (isset($request['query']['user_type']) && ($request['query']['user_type'] != "") ? $request['query']['user_type'] : '');
        $country_id = (isset($request['query']['country_id']) && ($request['query']['country_id'] != "") ? $request['query']['country_id'] : '');
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
        
        
        DB::statement(DB::raw('set @rownumber=' . $offset . ''));
        $users = DB::table('users')
                ->join('countries', 'users.country_id', '=', 'countries.id')
                ->select(DB::Raw('@rownumber:=@rownumber+1 as S_No'), 'users.id as userId', 'users.name', 'users.username', 'users.email', 'users.contact', 'users.status', 'users.user_type', 'countries.id as country_id', 'countries.country_name as country_name', 'users.fast_score')
                ->whereNotIn('users.user_type', [1]);
        if ($username !== '') {
            $users->where('users.name', 'like', $username . '%');
        }
        if ($user_type !== '') {
            $users->where('users.user_type', $user_type);
        }
        if ($country_id != '') {
            $users->where('users.country_id', $country_id);
        }
        if ($status != '') {
            $users = $users->where('users.status', $status);
        } else {
            $users = $users->where('users.status', 1);
        }
        if ($sortByField != '' && $orderBy != '') {
            $users = $users->orderBy($sortByField, $orderBy);
        }
        $total = $users->count();
        $users = $users->get();
        $meta = ['draw' => $draw, 'perpage' => $perpage, 'total' => $total, 'page' => $page];
        return $users;
    }

    /* --------- get users Data-------- */
    /*
     * @created : Jan 4, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to get all users data.
     * @params  : none
     * @return  : users
     */

    public static function Saveuser($request) {
        $id = $request->id;
        /* --------------------- check if Username already exist ------------------- */
        $check = User::where('username', '=', $request->input('username'))
                        ->where(function($query) use ($id) {
                            if (isset($id)) {
                                $query->where('id', '<>', $id);
                            }
                        })->exists();
        /* --------------------- end  Username already exist ------------------- */
        if ($check) {
            return array('status' => 'error', 'message' => "Username already exist.");
        }
        if ($request->id) {
            /* --------------------- User update ------------------- */
            $user = User::find($request->id);
        } else {
            /* --------------------- if new User ------------------- */
            $user = new User();
        }
        $user->country_id = $request->country_id;
        $user->user_type = $request->user_type;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->contact = $request->contact;
        $user->remember_token = $request->get['_token'];

        return $user;
    }

    /* --------- Edit User Data-------- */

    /* --------- Edit user Data-------- */
    /*
     * @created : Jan 3, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to edit user.
     * @params  : none
     * @return  : user data
     */

    public static function EditUser($request) {
        $id = $request->id;
        if ($id != '') {
            $user = User::find($id);
            return $user;
        } else {
            return "error";
        }
    }

    /*
     * @created : Jan 5, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to change user status active to archive .
     * @params  : none
     * @return  : none
     */

    public static function ArchiveStatus($request) {
        if ($request->id) {
            $user_detail = User::where(['id' => $request->id])->first();
            $user = User::find($user_detail->id);
            if ($user_detail->status == 1) {
                $user->status = 2;
            } else {
                $user->status = 1;
            }
            if ($user->save()) {
                return "success";
            }
        }
        return (json_encode(array('status' => 'error', 'message' => "No Such Record is Found!!!")));
    }

}
