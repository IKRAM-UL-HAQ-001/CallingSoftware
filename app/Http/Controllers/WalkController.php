<?php

namespace App\Http\Controllers;

use App\Models\Walk;
use Illuminate\Http\Request;

class WalkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.walk.list');
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
    public function show(Walk $walk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Walk $walk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Walk $walk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Walk $walk)
    {
        //
    }
}