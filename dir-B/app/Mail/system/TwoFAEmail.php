<?php

namespace App\Mail\system;

use App\Traits\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Cookie;

class TwoFAEmail extends Mailable
{
    use Queueable, SerializesModels, Mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->user = $data;
        $this->locale = Cookie::get('lang');

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $content = $this->parseEmailTemplate([
            '%user_name%' => $user->name,
            '%verification_code%' => session()->get('verification_code')
        ], 'TwoFAEmail', $this->locale, $user->company_id);
        return $this->view('system.mail.index', compact('content'));
    }
}
