<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $FollowUps = FollowUp::all();
        return view('admin.follow_up.list',compact('FollowUps'));
    }

    public function assistantIndex()
    {
        $FollowUps = FollowUp::all();
        return view('assistant.follow_up.list',compact('FollowUps'));
    }
    public function exchangeIndex()
    {   $exchageId = 1;
        $FollowUps = FollowUp::where('exchange_id', $exchageId);
        return view('assistant.follow_up.list',compact('FollowUps'));
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
    public function show(FollowUp $followUp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowUp $followUp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FollowUp $followUp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowUp $followUp)
    {
        //
    }
}
