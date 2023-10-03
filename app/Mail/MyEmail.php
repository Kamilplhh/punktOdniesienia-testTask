<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Attachment;

class MyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('emails.my_email')
            ->subject('Subject of your email');
    }
    /**
     * Create a new message instance.
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Costlinker - zipfile',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->path)
                ->as('attachment.zip')
                ->withMime('application/zip'),
        ];
    }
}
