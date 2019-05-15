<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;

class TestRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $user_id = ""; 
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $id = $this->user_id;
        $user = User::join('countries','countries.id','=','users.country_id')->select('users.id as child_id','users.name','users.username','users.email','countries.country_code','users.contact')->selectRaw("IFNULL((SELECT name FROM fi_users INNER JOIN fi_tag_parents ON fi_tag_parents.parent_id = fi_users.id WHERE fi_tag_parents.user_id = child_id limit 1),'') as parent_name")->where('users.id',$id)->first();
        
        $res = true;

        /*if($user->contact != "")
        {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $client = new Client($sid, $token);
              try {
              $res =  $client->messages->create(
                        // the number you'd like to send the message to
                        '+'.$user->country_code.$user->contact,
                        array(
                            // A Twilio phone number you purchased at twilio.com/console
                            'from' => '+15416159055',
                            // the body of the text message you'd like to send
                            'body' => "Hello $user->username your Parent - $user->parent_name requested you to Re-take fast test for better rank and score.",
                        )
                      );
                } catch (TwilioException $e) {
                    //return (json_encode(array('status' => 'error', 'message' => "Not sent")));
                }
        }*/
        
        if($user->email != ""){
            // If Email is exist then we send information in mail        
         $res = (new MailMessage)
                ->from('admin@fast_index.com', 'Fast Index Admin')
                ->subject('Request for Retest')
                ->markdown('mail.test.request', ['user' => $user]);
        }
        return $res;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
