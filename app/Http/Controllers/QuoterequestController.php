<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuoteRequestService;
use App\Services\SellmachineService;
use App\Services\UserService;

class QuoterequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QuoteRequestService $quoteRequestService)
    {
        //
        $quoteRequests = $quoteRequestService->getQuoteRequests();
        return view('quoterequests.index', compact('quoteRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(QuoteRequestService $quoteRequestService,SellmachineService $sellMachineService,UserService $userService)
    {
        //

        $sellMachines = $sellMachineService->getSellMachines();
        $type='customer';
        $users = $userService->getUsers($type);

        return view('quoterequests.create', compact('sellMachines','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,QuoteRequestService $quoteRequestService)
    {
        //
        $request->validate([
            'user_id' => 'required',
            'sell_machine_id' => 'required',
            'company' => 'required',
            'contact_name' => 'required',
            'email' => 'email',

        ]);
        $input = $request->all();

        $quoteRequestService->createQuoteRequest($input);

        return redirect()->route('quoterequests.index')->with('success', 'Quote Request created successfully');
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
    public function edit($id,QuoteRequestService $quoteRequestService,SellmachineService $sellMachineService)
    {
        //
        $id=decrypt($id);
        $sellMachines = $sellMachineService->getSellMachines();
        $quoteRequest = $quoteRequestService->getQuoteRequest($id);
        return view('quoterequests.edit',compact('quoteRequest','sellMachines'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,QuoteRequestService $quoteRequestService)
    {
        //
        $id=decrypt($id);
        $request->validate([
            'sell_machine_id' => 'required',
            'company' => 'required',
            'contact_name' => 'required',
            'email' => 'email',

        ]);

        $input = $request->all();
        $quoteRequest = $quoteRequestService->getQuoteRequest($id);

        $quoteRequestService->updateQuoteRequest($quoteRequest, $input);

        return redirect()->route('quoterequests.index')->with('success', 'Quote Request updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, QuoteRequestService $quoteRequestService)
    {
        $quoteRequest = $quoteRequestService->getQuoteRequest($id);



        $quoteRequestService->deleteQuoteRequest($quoteRequest);

        return redirect()->back()
            ->with('success', 'Quote Request deleted successfully');
    }
}
