<?php

namespace App\Http\Controllers;

use App\Models\AdoptionPlan;
use App\Http\Requests\StoreAdoptionPlanRequest;
use App\Http\Requests\UpdateAdoptionPlanRequest;
use Illuminate\Http\Request;
use App\Models\Animals;
use Illuminate\Support\Facades\Auth;

class AdoptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Animals $animals)
    {
        $user = Auth::user(); // Get the currently logged-in user

        $adoptionPlan = AdoptionPlan::create([
            'animal_id' => $animals->id,
            'user_id' => $user->id,
            'adopter_name' => $user->name,
            'adopter_email' => $user->email,
        ]);

        return redirect()->back()->with('success', 'Adoption plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AdoptionPlan $adoptionPlan)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdoptionPlan $adoptionPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdoptionPlanRequest $request, AdoptionPlan $adoptionPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdoptionPlan $adoptionPlan)
    {
        //
    }
}
