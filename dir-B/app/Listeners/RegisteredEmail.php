<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\system\AccountCreatedEmail;
use App\Mail\system\PasswordSetEmail;
use Illuminate\Support\Facades\Mail;

class RegisteredEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user;
          if (!isset($user->password)) {
            $encryptedToken = encrypt($event->token);
            Mail::to($user->email)->send(new PasswordSetEmail($user, $encryptedToken));
        } else {
            $user->userPasswords()->create(['password' => $user->password]);
            Mail::to($user->email)->send(new AccountCreatedEmail($user));
        }
    }
}
