<?php

namespace App\Http\Controllers;

use App\Models\Centers;
use Illuminate\Http\Request;

class CentersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centers = Centers::all();
        return view('centers.index', compact('centers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centers = Centers::all();
        return view('centers.create', compact('centers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'telephone' => 'required',
            'email' => 'required'
        ],
        [
            'name.required' => 'Name can\'t be empty!',
            'location.required' => 'Where is this? the void? Location can\'t be empty!',
            'telephone.required' => 'ring ring???',
            'email.required' => "Email can't be empty"
        ]);

        Centers::create([
            'name' => $request->name,
            'location' => $request->location,
            'telephone' => $request->telephone,
            'email' => $request->email
            ]);

        return redirect('/center');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $centers = Centers::findorfail($id);
        return view('centers.show', compact('centers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $centers = Centers::findorfail($id);
        return view('centers.edit', compact('centers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
        ],
        [
            'name.required' => 'Name can\'t be empty!',
            'location.required' => 'Location can\'t be empty!',
        ]);
    
        $center = Centers::findOrFail($id);
            
        $center_data = [
            'name' => $request->name,
            'location' => $request->location,
        ];
    
        $center->update($center_data);
    
        return redirect('/center');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $animals = Centers::findorfail($id);
        $animals->delete();

        return redirect('/center');
    }
}
