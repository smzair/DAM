<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WrcStatusUpdate extends Mailable
{
     use Queueable, SerializesModels;

    public $wrc;

    public function __construct($wrc)
    {
        $this->wrc = $wrc;
    }

    public function build()
    {
        return $this->subject('Status Update')->view('emails.mailstatus');
                    
    }

}
