<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CountryService;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CountryService $countryService)
    {
        //
        $countries = $countryService->getCountries();
        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,CountryService $countryService)
    {
        //
        $request->validate([
            'name' => 'required',


        ]);

        $input = $request->all();

        $countryService->createCountry($input);

        return redirect()->route('countries.index')->with('success', 'Country created successfully');
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
    public function edit($id,CountryService $countryService)
    {
        //
        $id=decrypt($id);
        $country = $countryService->getCountry($id);
        return view('countries.edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,CountryService $countryService)
    {
        //
        $id=decrypt($id);
        $request->validate([
            'name' => 'required',


        ]);

        $input = $request->all();

        // update brands

        $country = $countryService->getCountry($id);


        $countryService->updateCountry($country, $input);
        return redirect()->route('countries.index')->with('success', 'Country Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CountryService $countryService)
    {
        //
        $country = $countryService->getCountry($id);
        $countryService->deleteCountry($country);

        return redirect()->back()
            ->with('success', 'Country deleted successfully');
    }
}
