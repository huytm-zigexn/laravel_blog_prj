<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $postPerformance;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param array $postPerformance
     * @return void
     */
    public function __construct($postPerformance, $user)
    {
        $this->postPerformance = $postPerformance;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Monthly Post Performance Summary')
                    ->view('emails.post_summary')
                    ->with([
                        'postPerformance' => $this->postPerformance,
                        'user' => $this->user,
                    ]);
    }
}
