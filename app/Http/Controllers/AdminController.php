<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Services\UserService;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserService $userService)
    {
        //
        $type = 'admin';
        $users = $userService->getUsers($type);
        return view('admins.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::where('id', '<>', '6')->pluck('name', 'name')->all();

        return view('admins.create', compact('roles'));
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
            'password' => 'required',
            'roles'      => 'required',

        ]);
        $input = $request->all();

        $user = $userService->createUser($input);

        $userService->assignUserRoles($input, $user);

        return redirect()->route('admins.index')->with('success', 'Admin Added successfully');
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
    public function edit($id, UserService $userService)
    {
        //

        $user = $userService->getUser($id);
    
        $roles = Role::where('id', '<>', '6')->get(['id', 'name']);

        $userRoles = $user->roles->pluck('id')->toArray();

        return view('admins.edit', compact('user', 'roles', 'userRoles'));
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
            'roles'      => 'required',

        ]);
        $input = $request->all();
        $user = $userService->getUser($id);

        // update User
        $userService->updateUser($user, $input);
        return redirect()->route('admins.index')->with('success', 'Admin updated successfully');
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



        $userService->deleteUser($user);

        return redirect()->back()
            ->with('success', 'Admin deleted successfully');
    }
}
