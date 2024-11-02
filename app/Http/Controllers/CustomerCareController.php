<?php

namespace App\Http\Controllers;

use App\Models\CustomerCare;
use Illuminate\Http\Request;

class CustomerCareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $CustomerCares = CutomerCare::all();
        return view('admin.customer_care.list',compact('CustomerCare'));
    }
    public function assistantIndex()
    {
        $CustomerCares = CutomerCare::all();
        return view('assistant.customer_care.list',compact('CustomerCare'));
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
    public function show(CustomerCare $customerCare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerCare $customerCare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerCare $customerCare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerCare $customerCare)
    {
        //
    }
}
