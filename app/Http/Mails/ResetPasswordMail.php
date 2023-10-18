<?php

namespace App\Http\Mails;

use Illuminate\Mail\Mailable;

class ResetPasswordMail extends Mailable
{
    public $resetUrl;

    public function __construct($resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    public function build()
    {
        return $this->subject('WorkHunter - Resetowanie hasła')
            ->view('resetPassword');
    }
}