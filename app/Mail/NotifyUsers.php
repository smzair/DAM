<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUsers extends Mailable
{
    use Queueable, SerializesModels;
    public $notification_data;
    public $creation_type;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notification_data, $creation_type, $subject)
    {
        $this->notification_data = $notification_data;
        $this->creation_type = $creation_type;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('reports.userNotification');
    }
}
