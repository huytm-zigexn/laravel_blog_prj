<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // truyền user vào email

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Welcome to BLOSCOT')
                    ->view('emails.welcome');
    }
}
