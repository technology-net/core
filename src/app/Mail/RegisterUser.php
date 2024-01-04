<?php

namespace IBoot\Core\App\Mail;

use IBoot\Core\App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class RegisterUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('admin@icitech.net', config('core.mail_name')),
            subject: 'Password default',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $token = Str::random(60);
        Password::createToken($this->user, $token);

        return new Content(
            markdown: 'packages/core::emails.users.register',
            with: [
                'token' => $token,
            ],
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
