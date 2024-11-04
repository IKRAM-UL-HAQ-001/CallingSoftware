<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Exchanges = Exchange::all();
        $Users = User::whereNotIn('role', ['admin', 'assistant'])->get();
        return view('admin.user.list',compact('Exchanges','Users'));
    }

    public function assistantIndex()
    {
        
        $Users = User::all();
        return view('admin.user.list',compact('Users'));
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

    // Define validation rules
    $validator = Validator::make($request->all(), [
        'user_name' => 'required',
        'password' => 'required',
        'exchange_id' => 'nullable',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }

    try {
        // Get encrypted inputs
        $encryptedUserName = $request->input('user_name');
        $encryptedPassword = $request->input('password');
        $encryptedExchangeId = $request->input('exchange_id');
        
        // Store the data using Eloquent ORM
        $user = new User();
        $user->name = $encryptedUserName;
        $user->password = $encryptedPassword;
        $user->exchange_id = $encryptedExchangeId;
        $user->role = 'exchange';
        $user->save();

        return response()->json(['success' => 'User added successfully!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to add new user.', 'exception' => $e->getMessage()], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
