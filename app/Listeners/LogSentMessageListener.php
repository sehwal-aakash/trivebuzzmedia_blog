<?php

namespace App\Listeners;

use App\Models\EmailLog;
use Illuminate\Mail\Events\MessageSent;
use Symfony\Component\Mime\Address;

class LogSentMessageListener
{
    /**
     * Handle the mail sent event.
     */
    public function handle(MessageSent $event): void
    {
        try {
            $message = $event->message;

            $recipients = collect($message->getTo())
                ->map(fn (Address $address) => $address->getAddress())
                ->implode(', ');

            $subject = $message->getSubject() ?: '(No Subject)';
            $textBody = $message->getTextBody();
            $htmlBody = $message->getHtmlBody();

            $body = ! empty($textBody) ? $textBody : strip_tags($htmlBody ?? '');
            $snippet = str($body)->replace(["\r", "\n"], ' ')->squish()->limit(400);

            EmailLog::create([
                'recipient' => $recipients ?: 'unknown@domain.com',
                'subject' => $subject,
                'status' => 'sent',
                'body_snippet' => (string) $snippet,
                'sent_at' => now(),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
