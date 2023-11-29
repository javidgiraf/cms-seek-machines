<?php

namespace App\Services;

use Illuminate\Http\Request;
use DB;
use App\Models\Subscription;

class SubscriptionService
{

    public function getSubscriptions(): Object
    {
        return Subscription::orderBy('id', 'asc')->get();
    }
}
