<?php

namespace App\Http\Controllers;

use App\Models\NoOfCall;
use Illuminate\Http\Request;

class NoOfCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $NoOfCalls = NoOfCall::all();
        return view('admin.no_of_call.list',compact('NoOfCalls'));
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
    public function show(NoOFCall $noOFCall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NoOFCall $noOFCall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NoOFCall $noOFCall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NoOFCall $noOFCall)
    {
        //
    }
}
