<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sellmachine;
use Carbon\Carbon;
use App\Models\Subscription;

class ReportController extends Controller
{
  public function machineReport(Request $request)
  {

    return view('reports.monthly_report');
  }
  public function packageReport(Request $request)
  {

    // $packages = Subscription::with('membership')
    //  ->select('plan_id')
    //  ->selectRaw('count(*) as plan_count')
    //  ->groupBy('plan_id')
    //  ->orderByRaw('plan_count ASC') // Order by the count instead of id
    //  ->paginate(25);

    // $packages = Subscription::with('membership')
    //  ->select('plan_id')
    //  ->selectRaw('COUNT(plan_id) as plan_count')
    //  ->leftJoin('transaction_subscriptions as trans_sub', 'subscriptions.id', '=', 'trans_sub.subscription_id')
    //  ->leftJoin('transactions', 'trans_sub.transaction_id', '=', 'transactions.id')
    //  ->selectRaw('SUM(sm_transactions.total_amount) as total_amount') // Fixed syntax issue
    //  ->groupBy('plan_id')
    //  ->orderByRaw('plan_count ASC')
    //  ->paginate(25);

    return view('reports.package_report');
  }
  public function packageDetail($plan_id, $start_date = null, $end_date = null)
  {
    return view('reports.package_details', [
      'plan_id' => $plan_id,
      'start_date' => $start_date,
      'end_date' => $end_date,
    ]);
  }
  public function VerificationAdsReport(Request $request)
  {

    return view('reports.verification_report');
  }
  public function BuyersReport(Request $request)
  {
    return view('reports.buyers_report');
  }
  public function HotDeals(Request $request)
  {


    return view('reports.hot_deal_report');
  }
  public function HotDealDetails(Request $request)
  {

    return view('reports.hot_deal_view');
  }
  public function MachinesList(Request $request)
  {

    return view('reports.machines_report');
  }


}
