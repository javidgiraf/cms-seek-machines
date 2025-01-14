<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplySellingmachineAdStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $status_details;

    public function __construct($status_details)
    {
        $this->status_details = $status_details;
    }

    public function build()
    {
        return $this->view('emails.reply-sellmachine-ad-status')
            ->with([
                'status_description' => $this->status_details['status_description'],
                'status' => $this->status_details['status'],
                  'code' => $this->status_details['code'],
            ]);
    }

    public function attachments()
    {
        return [];
    }
}
