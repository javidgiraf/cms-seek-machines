<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BrandService;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BrandService $brandService)
    {
        //
        $brands = $brandService->getBrands();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BrandService $brandService)
    {
        //
        $request->validate([
            'manufacturer'      => 'required',
            'short_code'        => 'required|unique:brands,short_code',
            // 'single_image_url'  => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $input = $request->all();
        // $image_upload = $brandService->uploadImage($request);
        $brandService->createBrand($input);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully');
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
    public function edit($id, BrandService $brandService)
    {
        //
        $brand = $brandService->getBrand($id);
        return view('brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, BrandService $brandService)
    {
        //
        $request->validate([
            'manufacturer' => 'required',
            'short_code' => 'required|unique:brands,short_code,' . $id,
            //'logo_url'      => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        // update brands

        $brands = $brandService->getBrand($id);
        // $image_upload = null;
        // if (!empty($request->file('logo_url'))) {
        //     ($brands->logo_url) ? $brandService->deleteImage($brands->logo_url) : '';
        //     $image_upload = $brandService->uploadImage($request);
        // }

        $brandService->updateBrand($brands, $input);
        return redirect()->route('brands.index')->with('success', 'Brand Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, BrandService $brandService)
    {
        $brand = $brandService->getBrand($id);

        //$brandService->deleteImage($brand->logo_url);

        $brandService->deleteBrand($brand);

        return response()->json(array('success' => true, 'message' => 'Brand deleted Successfully'));

        // return redirect()->back()
        //     ->with('success', 'Brand deleted successfully');
    }

    public function updateStatus(Request $request, BrandService $brandService)
    {
        $input = $request->all();

        $brandService->updateStatus($input);

        return response()->json(array('success' => true, 'message' => 'Status Updated Successfully'));
    }
}
