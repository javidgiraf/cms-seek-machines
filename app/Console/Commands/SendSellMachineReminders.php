<?php

namespace App\Console\Commands;

use App\Models\Sellmachine;
use App\Jobs\SendScheduledEmail;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendSellMachineReminders extends Command
{
    protected $signature = 'send:sell-machine-reminders';
    protected $description = 'Send reminders for sell machines created 3 months ago';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Find sell machines created 3 months ago
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        $machines = Sellmachine::whereDate('created_at', '=', $threeMonthsAgo->toDateString())->get();


        foreach ($machines as $machine) {

          SendScheduledEmail::dispatch($machine);
        }

        $this->info('Reminders sent successfully.');
    }
}
