<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $token;
    public $name;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
        $this->name = $this->getUserNameByEmail($this->email);
    }
    public function getUserNameByEmail($email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            return $user->name;
        }

        return null; // Or handle the case where the user is not found
    }

    public function build()
    {
        return $this->subject('Password Reset')
            ->view('mail.password-reset')
            ->with([
                'email' => $this->email,
                'token' => $this->token,
            ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('TheGildedCanvas@gmail.com', 'TheGildedCanvas'),
            subject: 'Password Reset',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.password-reset',
            with: ['name' => $this->name ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
