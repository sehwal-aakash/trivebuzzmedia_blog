<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Comment $comment
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
        $commenterName = $this->comment->user->name ?? $this->comment->author_name ?? 'A reader';
        $postTitle = $this->comment->post->title ?? 'your article';

        return (new MailMessage)
            ->subject('New Comment on: '.$postTitle)
            ->greeting('Hello '.$notifiable->name.',')
            ->line($commenterName.' left a new comment on your article "'.$postTitle.'":')
            ->line('"'.str($this->comment->content)->limit(200).'"')
            ->action('View Article Comments', url(route('posts.show', $this->comment->post->slug ?? '')))
            ->line('Thank you for writing on TriveBuzz Media!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'comment_id' => $this->comment->id,
            'post_title' => $this->comment->post->title ?? '',
            'commenter' => $this->comment->user->name ?? $this->comment->author_name ?? 'Guest',
        ];
    }
}
