<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class ChildPassword extends Notification {

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $user_password;
    protected $child_username;

    public function __construct($password, $child_username) {
        $this->user_password = $password;
        $this->child_username = $child_username;
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
        return (new MailMessage)->markdown('mail.password.childpassword', ['user' => $notifiable, 'password' => $this->user_password, 'child_username' => $this->child_username]);
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
