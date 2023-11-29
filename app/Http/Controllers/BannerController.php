<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BannerService;

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
    public function edit($id, BannerService $bannerService)
    {
        //
        $id = decrypt($id);
        $banner = $bannerService->getBanner($id);
        return view('banners.edit', compact('banner'));
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
        $id = decrypt($id);
        $request->validate([
            'title' => 'required',
            'image_url' => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $input = $request->all();
        $banner = $bannerService->getBanner($id);
        $image_upload = null;
        if (!empty($request->file('image_url'))) {
            ($banner->image_url) ? $bannerService->deleteImage($banner->image_url) : '';
            $image_upload = $bannerService->uploadImage($request);
        }
        $bannerService->updateBanner($banner, $input, $image_upload);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully');
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

        $bannerService->deleteImage($banner->image_url);

        $bannerService->deleteBanner($banner);

        return redirect()->back()
            ->with('success', 'Banner deleted successfully');
    }
}
