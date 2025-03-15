<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $verificationUrl;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $user)
    {
        $this->name = $name;
        $this->email = $email;
        $this->verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->user_id, 'hash' => sha1($user->email)]
        );
    }

    public function build()
    {
        return $this->subject('Email Verification')
            ->view('mail.name')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'verificationUrl' => $this->verificationUrl
            ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('TheGildedCanvas@gmail.com', 'TheGildedCanvas'),
            subject: 'Email Verification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.name',
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
