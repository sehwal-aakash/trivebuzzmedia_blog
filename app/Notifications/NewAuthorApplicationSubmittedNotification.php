<?php

namespace App\Notifications;

use App\Models\AuthorApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAuthorApplicationSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public AuthorApplication $application
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $applicantName = $this->application->user->name ?? 'A user';

        return (new MailMessage)
            ->subject('New Author Application Submitted: '.$applicantName)
            ->greeting('Hello Admin,')
            ->line($applicantName.' has submitted an application to become a verified author on TriveBuzz Media.')
            ->line('Bio Snippet: "'.str($this->application->bio)->limit(150).'"')
            ->action('Review Application', url(route('admin.authors.applications')))
            ->line('Please review and approve or reject the application from your Admin Dashboard.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'applicant_name' => $this->application->user->name ?? '',
            'message' => 'New author application submitted by '.($this->application->user->name ?? 'User'),
        ];
    }
}
