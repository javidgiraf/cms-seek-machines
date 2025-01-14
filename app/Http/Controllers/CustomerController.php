<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\CountryService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserService $userService)
    {
        //
        $type = 'customer';
        $users = $userService->getUsers($type);


        return view('customers.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CountryService $countryService)
    {
        //
        $countries = $countryService->signupCountries();
        return view('customers.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserService $userService)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:customers,phone',
            'password' => 'required',
            //  'icon_url'      => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $input = $request->all();
        // $image_upload = $userService->uploadImage($request);
        $user = $userService->createUser($input);
        $user_id = $user->id;

        $userService->createCustomer($user_id, $input);

        return redirect()->route('customers.index')->with('success', 'Customer Added successfully');
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
    public function edit($id, UserService $userService, CountryService $countryService)
    {
        //
        $user = $userService->getUser($id);
        $countries = $countryService->signupCountries();

        return view('customers.edit', compact('user', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, UserService $userService)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => [
                'required',
                Rule::unique('customers')->ignore($id, 'user_id'),
            ],
            // 'icon_url'      => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $input = $request->all();

        // update brands

        $user = $userService->getUser($id);
        // $image_upload = null;
        // if (!empty($request->file('image_url'))) {
        //     ($user->customer->image_url) ? $userService->deleteImage($user->customer->image_url) : '';
        //     $image_upload = $userService->uploadImage($request);
        // }

        $userService->updateUser($user, $input);
        $userService->updateCustomer($id, $input);

        return redirect()->route('customers.index')->with('success', 'Customer Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, UserService $userService)
    {
        $user = $userService->getUser($id);

        //$userService->deleteImage($user->customer->image_url);

        $userService->deleteUser($user);

        return response()->json(array('success' => true, 'message' => 'Customer deleted Successfully'));

        // return redirect()->back()
        //     ->with('success', 'Customer deleted successfully');
    }

    public function updateStatus(Request $request, UserService $userService)
    {
        $input = $request->all();

        $userService->updateStatus($input);

        return response()->json(array('success' => true, 'message' => 'Customer Verified Successfully'));
    }
}
