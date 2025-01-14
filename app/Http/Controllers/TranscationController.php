<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoostAd;
use App\Models\Transaction;
use App\Services\SellmachineService;
use App\Services\BannerService;
use App\Services\SubscriptionService;

class TranscationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function verifyAdTransaction(SellmachineService $sellmachineService)
    {
        $sellMachinesverifyAdTransactions = $sellmachineService->getAllTransactionReport();
        $sum = 0.00;
        foreach ($sellMachinesverifyAdTransactions as $transaction) {
            $sum = $sum + $transaction->transaction->total_amount;
        }
        $total = number_format($sum, 2);
        return view('transactions.verify', compact('sellMachinesverifyAdTransactions', 'total'));
    }


    public function boostAdTransaction(BannerService $bannerService)
    {
        $boostAdTransactions = $bannerService->getTransactionBoostAd();
        $sum = 0.00;
        foreach ($boostAdTransactions as $transaction) {
            $sum = $sum + $transaction->transaction->total_amount;
        }
        $total = number_format($sum, 2);
        return view('transactions.boostads', compact('boostAdTransactions', 'total'));
    }

    public function subscriptionTransaction(SubscriptionService $subscriptionService)
    {
        $subscriptionTransactions = $subscriptionService->getAllSubscriptionsTransactionReport();
        $sum = 0.00;
        foreach ($subscriptionTransactions as $transaction) {
            $sum = $sum + $transaction->transaction->total_amount;
        }
        $total = number_format($sum, 2);
        return view('transactions.subscriptions', compact('subscriptionTransactions', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
