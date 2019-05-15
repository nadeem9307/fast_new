<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use DB;

class PasswordReset extends Notification {

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $user_token;

    public function __construct($token) {
       $this->user_token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
//        dd($notifiable);
        //$reset = \DB::table('password_resets')->where('email',$notifiable->email)->get()->first();
        return (new MailMessage)->markdown('mail.password.reset',['user' => $notifiable,'token'=>$this->user_token]);
        //$user = User::find($notifiable->id);
        /* if(!$user)
          return false;

          //$user->remember_token = $tokens;
          //$user->save();
          if($notifiable->email != ""){
          return (new MailMessage)
          ->from('admin@sms.com', 'Admin')
          ->subject('New  User Created')
          ->markdown('mail.password.reset', ['mail_data' => $this->mail_data]);

          } */
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
                //
        ];
    }

}
