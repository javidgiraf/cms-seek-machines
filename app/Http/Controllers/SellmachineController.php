<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SellmachineService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\CountryService;
use App\Services\UserService;



class SellmachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getSellMachines();
        return view('sellmachines.index', compact('sellMachines'));
    }

    public function active(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getActiveSellMachines();
        return view('sellmachines.activesellmachines', compact('sellMachines'));
    }

    public function inactive(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getInActiveSellMachines();
        return view('sellmachines.inactivesellmachines', compact('sellMachines'));
    }

    public function pending(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getPendingSellMachines();
        return view('sellmachines.pendingsellmachines', compact('sellMachines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BrandService $brandService, CategoryService $categoryService, UserService $userService, CountryService $countryService)
    {
        //
        $brands = $brandService->getBrands();
        $categories = $categoryService->getAllCategory();
        $type = 'customer';
        $users = $userService->getUsers($type);
        $countries = $countryService->getCountries();
        return view('sellmachines.create', compact('brands', 'categories', 'users', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SellmachineService $sellmachineService)
    {
        //
        $request->validate([
            'name' => 'required',
            // 'slug' => 'required|unique:sell_machines,slug',
            // 'item_code' => 'required|unique:sell_machines,item_code',
            'default_image'      => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id'      => 'required',

        ]);
        $price_visible = isset($request->price_visible) ? 1 : 0;
        $input = $request->all();
        $image_upload = $sellmachineService->uploadImage($request);
        $description_image_upload = $sellmachineService->uploadDescriptionImage($request);
        $data = $sellmachineService->createSellMachine($price_visible, $input, $image_upload, $description_image_upload);
        $id = $data->id;
        $sellmachineService->insertSellmachineimages($id, $input, $request);

        $sellmachineService->uploadCatalog($request, $id);
        $sellmachineService->addSpecifications($input, $id);

        return redirect()->route('sellmachines.index')->with('success', 'Sell Machine ad  created successfully');
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
    public function edit(
        $id,
        SellmachineService $sellmachineService,
        BrandService $brandService,
        CategoryService $categoryService,
        UserService $userService,
        CountryService $countryService
    ) {
        //
        // $id = decrypt($id);
        $sellmachine = $sellmachineService->getSellMachine($id);
        $sellmachineimages = $sellmachineService->getSellMachineImages($id);
        $brands = $brandService->getBrands();
        $categories = $categoryService->getAllCategory();
        $type = 'customer';
        $users = $userService->getUsers($type);
        $countries = $countryService->getCountries();

        $specifications = $sellmachineService->getSpecifications($id);
        $technicalpdf = $sellmachineService->getCatalogs($id);



        return view('sellmachines.edit', compact(
            'sellmachine',
            'sellmachineimages',
            'brands',
            'categories',
            'users',
            'countries',
            'specifications',
            'technicalpdf'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, SellmachineService $sellmachineService)
    {
        //
        // $id = decrypt($id);
        $request->validate([
            'name' => 'required',
            //'slug' => 'required|unique:sell_machines,slug,' . $id,
            //'item_code' => 'required|unique:sell_machines,item_code,' . $id,
            'default_image'      => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',


        ]);
        $price_visible = isset($request->price_visible) ? 1 : 0;

        $input = $request->all();
        $sellmachine = $sellmachineService->getSellMachine($id);
        $image_upload = null;
        if (!empty($request->file('default_image'))) {
            ($sellmachine->default_image) ? $sellmachineService->deleteImage($sellmachine->default_image) : '';
            $image_upload = $sellmachineService->uploadImage($request);
        }

        $description_image_upload = $sellmachineService->uploadDescriptionImage($request);
        $sellmachineService->updateSellmachine($id, $price_visible, $sellmachine, $input, $image_upload, $description_image_upload);
        $sellmachineService->insertSellmachineimages($id, $input, $request);

        $sellmachineService->updateCatalog($request, $id);

        $sellmachineService->addSpecifications($input, $id);

        return redirect()->route('sellmachines.index')->with('success', 'Sell Machine ad updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, SellmachineService $sellmachineService)
    {
        $sellmachine = $sellmachineService->getSellMachine($id);

        $sellmachineService->deleteImage($sellmachine->default_image);

        $sellmachineService->deleteSellMachine($sellmachine);

        return redirect()->back()
            ->with('success', 'Sell Machine ad deleted successfully');
    }
    public function deletesellMachineImage($id, SellmachineService $sellmachineService)
    {

        $sellmachineImage = $sellmachineService->getSellMachineImage($id);

        $sellmachineService->deleteImage($sellmachineImage->image_url);
        $sellmachineService->deleteSellMachineImage($sellmachineImage);

        return response()->json([

            'data' => true

        ]);
    }
    public function deleteSpecifications($id, SellmachineService $sellmachineService)
    {
        try {
            $res = $sellmachineService->deleteSpecification($id);
            return response()->json(['success' => $res]);
        } catch (\Exception $e) {

            // throw new HttpException(500, );
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
