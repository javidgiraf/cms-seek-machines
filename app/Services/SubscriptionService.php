<?php

namespace App\Services;

use Illuminate\Http\Request;
use DB;
use App\Models\Subscription;
use App\Models\TransactionSubscription;

class SubscriptionService
{

    public function getSubscriptions(): Object
    {
        return Subscription::orderBy('id', 'asc')->paginate(25);
    }

    public function getAllSubscriptionsTransactionReport(): Object
    {
        return TransactionSubscription::all();
    }

    public function updateCount(array $userData): void
    {

        $subscription =  Subscription::find($userData['subscriptionid']);

        $subscription->view_count = $userData['view_count'];
        $subscription->save();
    }
}
