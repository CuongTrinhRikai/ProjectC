<?php

namespace App\Mail\system;

use App\Traits\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Cookie;


class PasswordSetEmail extends Mailable
{
    use Queueable, SerializesModels, Mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $encryptedToken)
    {
        $this->user = $data;
        $this->token = $encryptedToken;
        $this->locale = Cookie::get('lang');

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $content = $this->parseEmailTemplate([
            '%user_name%' => $this->user->name,
            '%password_set_link%' => $this->user->getPasswordSetResetLink(true, $this->token)
        ], 'PasswordSetLinkEmail', $this->locale);
        return $this->view('system.mail.index', compact('content'));
    }
}
