<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class reportMail extends Mailable
{
    use Queueable, SerializesModels;
    
  public $reportdata;
    /**
     * 
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reportdata)
    {
        $this->reportdata = $reportdata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Connect Daily Usage Report')->view('emails.mail');
    }
}
