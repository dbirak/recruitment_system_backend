<?php

namespace App\Http\Mails;

use Illuminate\Mail\Mailable;

class CompanyForUserMail extends Mailable
{
    public $info;

    public function __construct($info)
    {
        $this->info = $info;
    }

    public function build()
    {
        return $this->subject('WorkHunter - Wiadomość od '.$this->info['company']['name'])
            ->view('companyForUserMail');
    }
}