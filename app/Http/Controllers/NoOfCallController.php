<?php

namespace App\Http\Controllers;

use App\Models\NoOfCall;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NoOfCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $NoOfCalls = PhoneNumber::whereDate('created_at', Carbon::today())
        ->where('status','deactive')
        ->get();
        return view('admin.no_of_call.list', compact('NoOfCalls'));
    }

    public function assistantIndex()
    {
        $NoOfCalls = PhoneNumber::whereDate('created_at', Carbon::today())
        ->where('status','!=','deactive')
        ->get();
        return view('assistant.no_of_call.list', compact('NoOfCalls'));
    }

    public function exchangeIndex()
    {
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $NoOfCalls = PhoneNumber::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)
        ->where('status','deactive')
        ->whereDate('created_at', Carbon::today())
        ->get();
        return view('exchange.no_of_call.list', compact('NoOfCalls'));
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
