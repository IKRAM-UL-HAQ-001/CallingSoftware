<?php

namespace App\Http\Controllers;

use App\Models\ReferId;
use Illuminate\Http\Request;

class ReferIdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.refer_id.list');
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
    public function show(ReferId $referId)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReferId $referId)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReferId $referId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReferId $referId)
    {
        //
    }
}