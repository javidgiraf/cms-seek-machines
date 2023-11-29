<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MembershipPlanService;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MembershipPlanService $membershipPlanService)
    {
        //
        $memberships = $membershipPlanService->getMemberships();
        return view('memberships.index', compact('memberships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('memberships.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MembershipPlanService $membershipPlanService)
    {
        //
        $request->validate([
            'title' => 'required',
            'pricing' => 'required',
            'no_of_month' => 'required',
            'description' => 'required'
        ]);

        $input = $request->all();

        $membershipPlanService->createMembershipPlan($input);

        return redirect()->route('memberships.index')->with('success', 'Membership created successfully');
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
    public function edit($id, MembershipPlanService $membershipPlanService)
    {
        //
        $membership = $membershipPlanService->getMembershipPlan($id);
        return view('memberships.edit', compact('membership'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, MembershipPlanService $membershipPlanService)
    {
        //

        $request->validate([
            'title' => 'required',
            'pricing' => 'required',
            'no_of_month' => 'required',
            'description' => 'required'
        ]);
        $input = $request->all();

        // update brands
        $membership = $membershipPlanService->getMembershipPlan($id);
        $membershipPlanService->updateMembershipPlan($membership, $input);

        return redirect()->route('memberships.index')->with('success', 'Plans Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, MembershipPlanService $membershipPlanService)
    {
        //
        $membershipPlanService->deleteMembershipPlan($id);

        return redirect()->back()
            ->with('success', 'Plans deleted successfully');
    }
}
