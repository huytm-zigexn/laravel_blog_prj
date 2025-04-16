<?php
namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserFollowed extends Notification
{
    use Queueable;
    protected $follower;
    
    public function __construct(User $follower)
    {
        $this->follower = $follower;
    }
    
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }
    
    public function toArray($notifiable)
    {
        return [
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'follower_avatar' => $this->follower->avatar,
            'message' => $this->follower->name . ' has followed you!',
        ];
    }
    
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'message' => $this->follower->name . ' has followed you!',
        ]);
    }
}