<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\TransactionVerifyAd;


class VerifiedSellingMachineAdTransactionFilters extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $keyword;
    public function render()
    {
        if (!empty($this->keyword)) {

            $keyword = $this->keyword;


            $sql = TransactionVerifyAd::select('transaction_verifyads.*')
                ->join('transactions', 'transactions.id', '=', 'transaction_verifyads.transaction_id')
                ->join('users', 'users.id', '=', 'transactions.user_id')
                ->join('sell_machines', 'sell_machines.id', '=', 'transaction_verifyads.sell_machine_id')
                ->where(function ($query) use ($keyword) {
                    $query->where('sell_machines.title', 'like', '%' . $keyword . '%')
                        ->orWhere('users.name', 'like', '%' . $keyword . '%')
                        ->orWhere('transactions.reference_id', 'like', '%' . $keyword . '%');
                });


            $sellMachinesverifyAdTransactions = $sql->orderby('sell_machines.title', 'asc')
                ->get();
            $sum = 0.00;
            foreach ($sellMachinesverifyAdTransactions as $transaction) {
                $sum = $sum + $transaction->transaction->total_amount;
            }
            $total = number_format($sum, 2);
        } else {


            $sellMachinesverifyAdTransactions = TransactionVerifyAd::select('transaction_verifyads.*')

                ->join('transactions', 'transactions.id', '=', 'transaction_verifyads.transaction_id')
                ->join('users', 'users.id', '=', 'transactions.user_id')
                ->join('sell_machines', 'sell_machines.id', '=', 'transaction_verifyads.sell_machine_id')->orderby('sell_machines.title', 'asc')->get();
            $sum = 0.00;
            foreach ($sellMachinesverifyAdTransactions as $transaction) {
                $sum = $sum + $transaction->transaction->total_amount;
            }
            $total = number_format($sum, 2);
        }

        return view('livewire.verified-selling-machine-ad-transaction-filters', compact('sellMachinesverifyAdTransactions', 'total'));
    }
}
