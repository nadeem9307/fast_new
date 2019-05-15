<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Notification;
//use App\Notifications\ReferFriends;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use App\User;
use App\Model\Countries;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReferFriend;
use App\Helpers\Helper;
use Response;
use Validator;
use Illuminate\Support\Facades\URL;
use Exception;

class ReferFriendsController extends Controller {
    /*
     * @created : Feb 05, 2019
     * @author  : Mohd Nadeem
     * @access  : public
     * @Purpose : This function is use to refer a friend to fast site.
     * @params  : None
     * @return  : None
     */

    public function ReferAFriend(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                        'referal_name' => 'required'
            ]);
            if ($validator->fails()) {
                $errorMsg = $validator->getMessageBag()->toArray();
                return Response::json(array('status' => 'error', 'message' => $errorMsg));
            } else {
                if (($request->referal_email == "") && ($request->referal_phone == "")) {
                    return Response::json(array('status' => 'error', 'message' => 'Please provide either mobile or email'));
                }
                $user = Auth::user();
                if ($request->referal_email != "") {
                    if (!filter_var($request->input('referal_email'), FILTER_VALIDATE_EMAIL)) {
                        return Response::json(array('status' => 'error', 'message' => 'Enter proper email address.'))->withHeaders([
                                    'Content-Type' => 'application/json',
                                    'Accept' => 'application/json',
                        ]);
                    }
                    $data['name'] = $request->referal_name;
                    $data['email'] = $request->referal_email;
                    $data['url'] = URL::to('/')."/refer/$user->fast_key";
//                    $data['url'] = "https://staging.quizme.com.my/fast_index/refer/$user->fast_key";
                    Mail::to($request->referal_email)->send(new ReferFriend($data));
                }
                if ($request->referal_phone != "") {
                    if (!is_numeric($request->input('referal_phone'))) {
                        return Response::json(array('status' => 'error', 'message' => 'Mobile number must be a number.'))->withHeaders([
                                    'Content-Type' => 'application/json',
                                    'Accept' => 'application/json',
                        ]);
                    }
                    $country_code = Countries::where('id', $user->country_id)->select('country_code')->first();
                    // If mobile number is exist then we send information in mobile
//                    $sid = 'ACbfcf0a5d3a4790cc95d0ad12b2e7dd19';
//                    $token = '5930ab90756eade8563f0acc74ba5f69';
//                    $client = new Client($sid, $token);
//                    try {
//                        $message = $client->messages->create(
//                                // the number you'd like to send the message to
//                                '+918960850272', array(
//                            // A Twilio phone number you purchased at twilio.com/console
//                            'from' => '+15416159055',
//                            // the body of the text message you'd like to send
//                            'body' => "Hello $request->referal_name Please Register on this Given link For Fast Index.". URL::to('/')."/register/$user->fast_key",
//                                // 'mediaUrl' => 'http://big5kayakchallenge.com/wp-content/uploads/2018/01/inspirational-wallpaper-for-mobile-samsung-hii-wallpapers-to-your-cell-phone-hello-hi-wallpaper-for-mobile-samsung.jpg'
//                                )
//                        );
//                    } catch (TwilioException $e) {
//                        return Response::json(array('status' => 'error', 'message' => 'Incorrect mobile number or country code please check.'))->withHeaders([
//                                    'Content-Type' => 'application/json',
//                                    'Accept' => 'application/json',
//                        ]);
//                    }
                }
                return Response::json(array('status' => 'success', 'message' => 'Referred successfully.'));
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            Helper::store_error_log($ex->getMessage(), $ex->getLine(), $ex->getFile());
            return (json_encode(array('status' => 'error', 'message' => $ex->getMessage())));
        } catch (\Exception $e) {
            Helper::store_error_log($e->getMessage(), $e->getLine(), $e->getFile());
            return (json_encode(array('status' => 'error', 'message' => $e->getMessage())));
        }
    }

}
