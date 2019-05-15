<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferFriend extends Mailable
{
    use Queueable, SerializesModels;
    protected $user_data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->user_data = $data;
        //print_r($this->user_data); die;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('anup.singh2494@gmail.com')->markdown('mail.referfriend.request')
        ->with([
            'data' => $this->user_data
        ]);
    }
}
