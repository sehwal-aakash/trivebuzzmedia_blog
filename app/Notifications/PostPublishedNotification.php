<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostPublishedNotification extends Notification implements ShouldQueue
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
        return (new MailMessage)
            ->subject('🎉 Your Post is Live: '.$this->post->title)
            ->greeting('Congratulations '.$notifiable->name.'!')
            ->line('Great news! Your article "'.$this->post->title.'" has been published on TriveBuzz Media.')
            ->action('View Published Article', url(route('posts.show', $this->post->slug)))
            ->line('Share it with your network and start gathering readers!');
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
            'slug' => $this->post->slug,
        ];
    }
}
