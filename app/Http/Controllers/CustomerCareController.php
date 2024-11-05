<?php

namespace App\Http\Controllers;

use App\Models\CustomerCare;
use App\Models\User;
use App\Models\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerCareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Exchanges = Exchange::all();
        $CustomerCares = User::where('role','customercare')->get();
        return view('admin.customer_care.list',compact('CustomerCares','Exchanges'));
    }
    public function assistantIndex()
    {
        $CustomerCares = CustomerCare::all();
        return view('assistant.customer_care.list',compact('CustomerCares'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required',
            'exchange' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
    
        try {
            // Get encrypted inputs
            $encryptedUserName = $request->input('user_name');
            $encryptedPassword = $request->input('password');
            $encryptedExchange = $request->input('exchange');
            
            // Store the data using Eloquent ORM
            $user = new User();
            $user->name = $encryptedUserName;
            $user->password = $encryptedPassword;
            $user->exchange_id = $encryptedExchange;
            $user->role = 'customercare';
            $user->save();
    
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
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
