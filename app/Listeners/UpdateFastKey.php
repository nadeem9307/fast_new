<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\User;

class UpdateFastKey
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $random_string = md5(microtime());
        $user = User::where('id', $event->user->id)->first();
        if($user->fast_key=='' || $user->fast_key=='null')
        {
            User::where('id', $event->user->id)
            ->update(['fast_key' => $random_string]);
        }
        else
        {
            //
        }
    }
}
