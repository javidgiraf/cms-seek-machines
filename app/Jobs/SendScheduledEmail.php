<?php
namespace App\Jobs;

use App\Mail\ThreeMonthScheduledEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendScheduledEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $machine;

    public function __construct($machine)
    {
        $this->machine = $machine;
    }

    public function handle()
    {
        Mail::to($this->machine->user->email)->send(new ThreeMonthScheduledEmail($this->machine));
    }
}
