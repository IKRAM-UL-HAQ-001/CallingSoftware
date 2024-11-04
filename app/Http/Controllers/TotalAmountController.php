<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Illuminate\Http\Request;
use App\Models\TotalAmount;
class TotalAmountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $TotalAmounts = TotalAmount::all();

        return view('admin.amount.list', compact('TotalAmounts'));
    }
    public function exchnageindex()
    {
        $TotalAmounts = TotalAmount::all();
        return view('exchange.amount.list', compact('TotalAmounts'));
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
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cr $cr)
    {
        //
    }
}
