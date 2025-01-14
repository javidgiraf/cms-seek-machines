<?php

namespace App\Http\Controllers;

use App\Models\BoostAdPackage;
use App\Models\BoostAd;
use App\Models\BoostadDate;
use Illuminate\Http\Request;

class BoostAdPackageController extends Controller
{
    // Display a listing of boost ad packages
    public function index()
    {
        $packages = BoostAdPackage::all();
        return view('packages.index', compact('packages'));
    }

    // Show the form for creating a new boost ad package
    public function create()
    {
        return view('packages.create');
    }

    // Store a newly created boost ad package in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'pricing' => 'required|numeric',
            'no_of_days' => 'required|integer',
            'discount' => 'nullable|integer',
            'status' => 'required|boolean',  // 1 or 0 for status
        ]);

        BoostAdPackage::create($validatedData);

        return redirect()->route('boost-ad-packages.index')->with('success', 'Boost ad package created successfully.');
    }

    // Show the form for editing the specified boost ad package
    public function edit($id)
  {
      // Find the Boost Ad Package by its ID
      $package = BoostAdPackage::findOrFail($id); // Adjust this line based on your actual model name

      // Return the edit view with the package data
      return view('packages.edit', compact('package'));
  }
    // Update the specified boost ad package in storage
    public function update(Request $request, BoostAdPackage $boostAdPackage)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'pricing' => 'required|numeric',
            'no_of_days' => 'required|integer',
            'discount' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $boostAdPackage->update($validatedData);

        return redirect()->route('boost-ad-packages.index')->with('success', 'Boost ad package updated successfully.');
    }

    // Remove the specified boost ad package from storage
    public function destroy(BoostAdPackage $boostAdPackage)
    {
        $boostAdPackage->delete();
        return redirect()->route('boost-ad-packages.index')->with('success', 'Boost ad package deleted successfully.');
    }
      public function list()
    {
        $boostAds = BoostAd::with('package')->get();

        return view('packages.boost-ad-list', compact('boostAds'));
    }
    public function show($id)
   {

         $boostAd = BoostAd::with('boostedDate')->findOrFail($id);

      return view('packages.show', compact('boostAd'));
   }
}
