<?php

namespace App\Models\Observers;

use App\Models\User;
use Log;

class UserObserver

{
    public function created(User $user)
    {
        //Log::info('User Created', ['action'=>'created','id'=>$user->id]);

        //SendUserVerificationEmail
    }
    
}