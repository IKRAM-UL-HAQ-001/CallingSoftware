<?php

namespace App\Http\Controllers;

use App\Models\DemoSend;
use Illuminate\Http\Request;

class DemoSendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('admin.demo_send.list');
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
    public function show(DemoSend $demoSend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DemoSend $demoSend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DemoSend $demoSend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DemoSend $demoSend)
    {
        //
    }
}