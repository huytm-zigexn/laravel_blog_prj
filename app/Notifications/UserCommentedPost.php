<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserCommentedPost extends Notification
{
    use Queueable;

    protected $user;
    protected $post;
    
    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar,
            'message' => Str::limit('<a href="' . route('user.show', $this->user->id) . '">' . $this->user->name . '</a>' . ' has commented ' . '<a href="' . route('posts.show', $this->post->slug) . '">' . $this->post->title . '</a>', 200),
        ];
    }
    
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar,
            'message' => Str::limit('<a href="' . route('user.show', $this->user->id) . '">' . $this->user->name . '</a>' . ' has commented ' . '<a href="' . route('posts.show', $this->post->slug) . '">' . $this->post->title . '</a>', 200),
        ]);
    }
}
