<?php

namespace App\Http\Controllers;

use App\Models\TotalCall;
use Illuminate\Http\Request;

class TotalCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $TotalCalls = TotalCall::all();
        return view('admin.total_call.list',compact('TotalCalls'));
    }
    public function assistantIndex()
    {
        $TotalCalls = TotalCall::all();
        return view('assiatant.total_call.list',compact('TotalCalls'));
    }
    public function exchangeIndex()
    {   $exchageId = 1;
        $TotalCalls = TotalCall::where('exchange_id', $exchageId);
        return view('assistant.total_call.list',compact('TotalCalls'));
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
    public function show(TotalCall $totalCall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TotalCall $totalCall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TotalCall $totalCall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TotalCall $totalCall)
    {
        //
    }
}
