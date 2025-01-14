<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeekAgent;
use App\Models\User;

class SeekAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
   {
       $agents = SeekAgent::paginate(10); // Use paginate directly
       return view('seekagent.index', compact('agents'));
   }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $users = User::all();
         return view('seekagent.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'user_id' => 'required',
        'designation' => 'required',
        'phone' => 'required',

    ]);
  $input = $request->all();

    SeekAgent::create([
        'user_id' => $input['user_id'],
        'designation' => $input['designation'],
        'phone' =>  $input['phone'],
        'status' => isset($input['status']) ? 1 : 0,
        'image_url'=>isset($input['image_url']) ? $input['image_url'] : ''


    ]);

    return redirect()->route('seekagent.index')->with('success', 'Seek Agent created successfully.');
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
     public function edit($id)
     {
         $agent = SeekAgent::findOrFail($id);
         $users = User::all();
         return view('seekagent.edit', compact('agent','users'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
   $agent = SeekAgent::findOrFail($id);
   $input = $request->all();

   $agent->update([
       'user_id' => $input['user_id'],
       'designation' => $input['designation'],
       'phone' => $input['phone'],
       'status' => $request->status ? 1 : 0,
       'image_url'=>isset($input['image_url']) ? $input['image_url'] : ''
   ]);

   return redirect()->route('seekagent.index')->with('success', 'Seek Agent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $agent = SeekAgent::findOrFail($id);
      $agent->delete();

    return redirect()->route('seekagents.index')->with('success', 'Seek Agent deleted successfully.');
    }
}
