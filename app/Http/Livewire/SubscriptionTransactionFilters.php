<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TransactionSubscription;

class SubscriptionTransactionFilters extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $keyword;
    public function render()
    {
        if (!empty($this->keyword)) {

            $keyword = $this->keyword;


            $sql = TransactionSubscription::select('transaction_subscriptions.*')
                ->join('transactions', 'transactions.id', '=', 'transaction_subscriptions.transaction_id')
                ->join('users', 'users.id', '=', 'transaction_subscriptions.user_id')
                ->join('sell_machines', 'sell_machines.id', '=', 'transaction_verifyads.sell_machine_id')
                ->where(function ($query) use ($keyword) {
                    $query->where('users.name', 'like', '%' . $keyword . '%')
                        ->orWhere('transactions.reference_id', 'like', '%' . $keyword . '%');
                });


            $subscriptionTransactions = $sql->orderby('transaction_subscriptions.id', 'asc')
                ->get();
            $sum = 0.00;
            foreach ($subscriptionTransactions as $transaction) {
                $sum = $sum + $transaction->transaction->total_amount;
            }
            $total = number_format($sum, 2);
        } else {


            $subscriptionTransactions = TransactionSubscription::select('transaction_subscriptions.*')

                ->join('transactions', 'transactions.id', '=', 'transaction_subscriptions.transaction_id')
                ->join('users', 'users.id', '=', 'transaction_subscriptions.user_id')
                ->orderby('transaction_subscriptions.id', 'asc')
                ->get();

            $sum = 0.00;
            foreach ($subscriptionTransactions as $transaction) {
                $sum = $sum + $transaction->transaction->total_amount;
            }
            $total = number_format($sum, 2);
        }

        return view('livewire.subscription-transaction-filters', compact('subscriptionTransactions', 'total'));
    }
}
