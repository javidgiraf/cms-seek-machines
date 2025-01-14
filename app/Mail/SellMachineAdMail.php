<?php

namespace App\Mail;

use App\Models\Sellmachine; // Ensure this is imported
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellMachineAdMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sellMachine;

    /**
     * Create a new message instance.
     *
     * @param Sellmachine $sellMachine
     * @return void
     */
    public function __construct(Sellmachine $sellMachine)
    {
        $this->sellMachine = $sellMachine;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.sell_machine_ad')
                    ->subject('Selling Machine Ad Details')
                    ->with([
                        'title' => $this->sellMachine->title,
                        'item_code' => $this->sellMachine->item_code,
                        'description' => $this->sellMachine->description,

                    ]);
    }
}
