<?php

namespace App\Mail\system;

use App\Traits\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Cookie;


class PasswordResetEmail extends Mailable
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
            '%password_reset_link%' => $this->user->getPasswordSetResetLink(false, $this->token)
        ], 'PasswordResetLinkEmail', $this->locale, $this->user->company_id);
        return $this->view('system.mail.index', compact('content'));
    }
}
