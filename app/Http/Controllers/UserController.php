<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Exchange;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userRecords = User::with('exchange')->whereNotIn('role', ['admin', 'carecenter'])->get();
        $exchangeRecords = Exchange::all();
        return view("admin.user.list", compact('userRecords', 'exchangeRecords'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'exchange' => 'required|exists:exchanges,id',
        ]);
        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password), 
            'exchange_id' => $request->exchange,
            'role' => "exchange",
        ]);
        return redirect()->route('admin.user.list')->with('success', 'User store successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
    
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'exchange' => 'required|exists:exchanges,id',
            'password' => 'nullable|string|min:8', // Password is optional
        ]);
    
        $user->name = $request->name;
        $user->exchange_id = $request->exchange;
    
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password); // Hash the new password
        }
    
        $user->save();
        return redirect()->route('admin.user.list')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);
        
        $user = User::find($request->id);
        
        if ($user) {
            $user->delete();
            return redirect()->route('admin.user.list')->with('success', 'User deleted successfully!');
        }
        
        return redirect()->route('admin.user.list')->with('error', 'User not found.');
    }
}
