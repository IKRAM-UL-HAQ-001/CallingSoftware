<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Exchanges = Exchange::all();
        return view('admin.exchange.list',compact('Exchanges'));
    }

    public function assistantIndex()
    {
        $Exchanges = Exchange::all();
        return view('assistant.exchange.list',compact('Exchanges'));
    }

    public function store(Request $request)
    {
        {
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'exchange_name' => 'required|unique:exchanges,name',
            ]);
        
            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }
        
            try {
                $encryptedExchangeName = $request->input('exchange_name');        
        
                // Store the data using Eloquent ORM
                $exchange = new Exchange();
                $exchange->name = $encryptedExchangeName;
                $exchange->save();
        
                return redirect()->back();
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Exchange $exchange)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exchange $exchange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exchange $exchange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exchange $exchange)
    {
        //
    }
}
