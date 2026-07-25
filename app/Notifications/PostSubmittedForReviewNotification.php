<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostSubmittedForReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Post $post
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
        $authorName = $this->post->author->name ?? 'An author';

        return (new MailMessage)
            ->subject('New Post Submitted for Review: '.$this->post->title)
            ->greeting('Hello Editor,')
            ->line($authorName.' has submitted a new post titled "'.$this->post->title.'" for editorial review.')
            ->action('Review Post', url(route('admin.posts.edit', $this->post)))
            ->line('Please inspect and approve the post for publication.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'author_name' => $this->post->author->name ?? '',
        ];
    }
}
