<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use SerializesModels;

    public $email;
    public $token;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }


    public function build()
    {
        return $this->subject('Reset Your Password')
            ->view('mail.reset-password')
            ->with([
                'email' => $this->email,
                'token' => $this->token,
                'resetUrl' => url("password/reset/{$this->token}") . '?email=' . urlencode($this->email)
            ]);
    }
}
