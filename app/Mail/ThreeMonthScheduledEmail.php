<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThreeMonthScheduledEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $machine;

    public function __construct($machine)
    {
        $this->machine = $machine;
    }

    public function build()
    {
    
        return $this->subject('Reminder: Action Required on Sell Machine')
                    ->view('emails.threemonth_reminder')
                    ->with('machine', $this->machine);
    }
}
