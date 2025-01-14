<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SellmachineService;
use App\Services\BannerService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(SellmachineService $sellmachineService, BannerService $bannerService)
    {
        $sellMachines = $sellmachineService->getPendingSellMachines();
        $banners = $bannerService->getOnReviewBanners();
        $sellMachinesPendingads = $sellmachineService->getAdVerifyPendingSellMachines();
        return view('home', compact('sellMachines', 'banners', 'sellMachinesPendingads'));
    }
}
