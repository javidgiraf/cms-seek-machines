<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BuyerRequestService;
use App\Services\CategoryService;
use App\Services\UserService;

class BuyerrequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BuyerRequestService $buyerRequestService)
    {
        //
        $buyerRequests = $buyerRequestService->getBuyerRequests();
        return view('buyerrequests.index', compact('buyerRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BuyerRequestService $buyerRequestService,CategoryService $categoryService,UserService $userService)
    {
        //

        $categories = $categoryService->getAllCategory();
        $type='customer';
        $users = $userService->getUsers($type);

        return view('buyerrequests.create', compact('categories','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,BuyerRequestService $buyerRequestService)
    {
        //
        $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'company' => 'required',
            'contact_name' => 'required',
            'email' => 'email',

        ]);
        $input = $request->all();

        $buyerRequestService->createBuyerRequest($input);

        return redirect()->route('buyerrequests.index')->with('success', 'Buyer Request created successfully');
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
    public function edit($id,BuyerRequestService $buyerRequestService,CategoryService $categoryService)
    {
        //
        $id=decrypt($id);
        $categories = $categoryService->getAllCategory();
        $buyerRequest = $buyerRequestService->getBuyerRequest($id);
        return view('buyerrequests.edit',compact('buyerRequest','categories'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,BuyerRequestService $buyerRequestService)
    {
        //
        $id=decrypt($id);
        $request->validate([
            'category_id' => 'required',
            'company' => 'required',
            'contact_name' => 'required',
            'email' => 'email',

        ]);

        $input = $request->all();
        $buyerRequest = $buyerRequestService->getBuyerRequest($id);

        $buyerRequestService->updateBuyerRequest($buyerRequest, $input);

        return redirect()->route('buyerrequests.index')->with('success', 'Buyer Request updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, BuyerRequestService $buyerRequestService)
    {
        $buyerRequest = $buyerRequestService->getBuyerRequest($id);



        $buyerRequestService->deleteBuyerRequest($buyerRequest);

        return redirect()->back()
            ->with('success', 'Buyer Request deleted successfully');
    }
}
