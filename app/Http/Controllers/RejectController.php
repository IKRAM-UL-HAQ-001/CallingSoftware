<?php

namespace App\Http\Controllers;

use App\Models\Reject;
use Illuminate\Http\Request;

class RejectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Rejects = Reject::all();
        return view('admin.reject.list',compact('Rejects'));
    }

    public function assistantIndex()
    {
        $Rejects = Reject::all();
        return view('assistant.reject.list',compact('Rejects'));
    }
    public function exchangeIndex()
    {   $exchageId = 1;
        $Rejects = Reject::where('exchange_id', $exchageId);
        return view('assistant.reject.list',compact('Rejects'));
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
    public function show(Reject $reject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reject $reject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reject $reject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reject $reject)
    {
        //
    }
}
