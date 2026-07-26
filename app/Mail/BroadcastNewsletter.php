<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BroadcastNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $subjectStr,
        public string $bodyContent,
        public ?string $unsubscribeToken = null
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromName = config('mail.from.name') && config('mail.from.name') !== 'Laravel'
            ? config('mail.from.name')
            : 'TriveBuzz Media';

        $fromAddress = config('mail.from.address') && config('mail.from.address') !== 'hello@example.com'
            ? config('mail.from.address')
            : 'noreply@trivebuzzmedia.co.uk';

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: $this->subjectStr,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.newsletter.broadcast',
            with: [
                'subjectStr' => $this->subjectStr,
                'content' => $this->bodyContent,
                'unsubscribeToken' => $this->unsubscribeToken,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
