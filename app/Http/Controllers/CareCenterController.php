<?php

namespace App\Http\Controllers;

use App\Models\CareCenter;
use Illuminate\Http\Request;

class CareCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("care_center.dashboard");
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
    public function show(CareCenter $careCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CareCenter $careCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CareCenter $careCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CareCenter $careCenter)
    {
        //
    }
}
