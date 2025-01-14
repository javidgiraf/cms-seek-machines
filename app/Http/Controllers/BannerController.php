<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BannerService;
use App\Services\SettingService;
use App\Services\SellmachineService;


class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(BannerService $bannerService)
    {
        //
        $banners = $bannerService->getBanners();
        return view('banners.index', compact('banners'));
    }

    public function active(BannerService $bannerService)
    {
        //

        $banners = $bannerService->getActiveBanners();
        return view('banners.activebanners', compact('banners'));
    }

    public function inactive(BannerService $bannerService)
    {
        //

        $banners = $bannerService->getInActiveBanners();
        return view('banners.inactivebanners', compact('banners'));
    }

    public function onreview(BannerService $bannerService)
    {
        //

        $banners = $bannerService->getOnReviewBanners();
        return view('banners.onreviewbanners', compact('banners'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BannerService $bannerService)
    {
        //
        $request->validate([
            'title' => 'required',
            'image_url'      => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $input = $request->all();
        $image_upload = $bannerService->uploadImage($request);
        $bannerService->createBanner($input, $image_upload);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully');
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
    public function edit($id, BannerService $bannerService, SettingService $settingService)
    {
        //
        $banner = $bannerService->getBanner($id);
        $title = 'boostad_amount';
        $adamount = $settingService->getSettingByTitle($title);


        return view('banners.edit', compact('banner', 'adamount'));
    }


    public function view($id, BannerService $bannerService, SettingService $settingService, SellmachineService $sellmachineService)
    {
        //
        $banner = $bannerService->getBanner($id);

        $title = 'boostad_amount';
        $adamount = $settingService->getSettingByTitle($title);

        $machinead = $sellmachineService->getSellMachine($banner->boostad->sell_machine_id);

        return view('banners.view', compact('banner', 'adamount', 'machinead'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, BannerService $bannerService)
    {
        //
        $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'label'         => 'required',
            'no_of_days'    => 'required',
            'total_amount'  => 'required',
            'start_date'    => 'required',
            'end_date'      => 'required',
            'image_url'     => 'required',
            //   'image_url' => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        $banner = $bannerService->getBanner($id);

        // $image_upload = null;
        // if (!empty($request->file('image_url'))) {
        //     ($banner->image_url) ? $bannerService->deleteImage($banner->image_url) : '';
        //     $image_upload = $bannerService->uploadImage($request);
        // }

        $bannerService->updateBanner($banner, $input);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully');
    }

    public function changestatus(Request $request, $id, BannerService $bannerService)
    {
        //
        $request->validate([
            'status'            => 'required',
            // 'start_date'        => 'required|date|after:today',
            // 'end_date'          => 'required|date|after:start_date',
        ]);
        $input = $request->all();

        $boostads = $bannerService->getBoosterAd($id);
        $bannerService->updateBannerStatus($boostads, $input);

        if (isset($input['isajax']) && $input['isajax']) {
            return response()->json(array('success' => true, 'message' => 'Status Updated Successfully'));
        } else {
            return redirect()->route('banners.view', $id)->with('success', 'Banner Status updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, BannerService $bannerService)
    {
        $banner = $bannerService->getBanner($id);

        $bannerService->deleteBanner($banner);

        return response()->json(array('success' => true, 'message' => 'Banner deleted Successfully'));

        // return redirect()->back()
        //     ->with('success', 'Banner deleted successfully');
    }
}
