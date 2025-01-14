<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TransactionAd;



class BoostAdTransactionFilters extends Component
{

    protected $paginationTheme = 'bootstrap';

    public $keyword;

    public function render()
    {
        if (!empty($this->keyword)) {

            $keyword = $this->keyword;


            $sql = TransactionAd::select('transaction_ads.*')
                ->join('boost_ads', 'boost_ads.id', '=', 'transaction_ads.ad_id')
                ->join('transactions', 'transactions.id', '=', 'transaction_ads.transaction_id')
                ->join('users', 'users.id', '=', 'transactions.user_id')
                ->join('sell_machines', 'sell_machines.id', '=', 'boost_ads.sell_machine_id')
                ->where(function ($query) use ($keyword) {
                    $query->where('sell_machines.title', 'like', '%' . $keyword . '%')
                        ->orWhere('users.name', 'like', '%' . $keyword . '%')
                        ->orWhere('transactions.reference_id', 'like', '%' . $keyword . '%');
                });


            $boostAdTransactions = $sql->orderby('sell_machines.title', 'asc')
                ->get();
            $sum = 0.00;
            foreach ($boostAdTransactions as $transaction) {
                $sum = $sum + $transaction->transaction->total_amount;
            }
            $total = number_format($sum, 2);
        } else {


            $boostAdTransactions = TransactionAd::select('transaction_ads.*')
                ->join('boost_ads', 'boost_ads.id', '=', 'transaction_ads.ad_id')
                ->join('transactions', 'transactions.id', '=', 'transaction_ads.transaction_id')
                ->join('users', 'users.id', '=', 'transactions.user_id')
                ->join('sell_machines', 'sell_machines.id', '=', 'boost_ads.sell_machine_id')->orderby('sell_machines.title', 'asc')->get();
            $sum = 0.00;
            foreach ($boostAdTransactions as $transaction) {
                $sum = $sum + $transaction->transaction->total_amount;
            }
            $total = number_format($sum, 2);
        }
        return view('livewire.boost-ad-transaction-filters', compact('boostAdTransactions', 'total'));
    }
}
