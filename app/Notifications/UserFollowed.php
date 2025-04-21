<?php
namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserFollowed extends Notification
{
    use Queueable;
    protected $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }
    
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar,
            'message' => '<a href="' . route('user.show', $this->user->id) . '">' . $this->user->name . '</a>' . ' has followed you!',
        ];
    }
    
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar,
            'message' => '<a href="' . route('user.show', $this->user->id) . '">' . $this->user->name . '</a>' . ' has followed you!',
        ]);
    }
}