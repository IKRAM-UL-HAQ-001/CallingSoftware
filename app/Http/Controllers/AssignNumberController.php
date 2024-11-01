<?php

namespace App\Http\Controllers;

use App\Models\AssignNumber;
use Illuminate\Http\Request;

class AssignNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.assign_number.list');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignNumber $assignNumber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssignNumber $assignNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssignNumber $assignNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssignNumber $assignNumber)
    {
        //
    }
}
