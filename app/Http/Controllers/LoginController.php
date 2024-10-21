<?php

namespace App\Http\Controllers;

use App\Models\login;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
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

        // Validate incoming request
        $this->validate($request, [
            'userRole' => 'required|string',
            'name' => 'required|string',
            'password' => 'required|string|min:8',
            'exchange' => 'nullable|required_if:userRole,exchange|string'
        ]);

        if (Auth::attempt($request->only('name', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'exchange':
                    return redirect()->route('exchange.dashboard');
                case 'carecenter':
                    return redirect()-> route('care_center.dashboard');
                default:
                return redirect()->back()->withErrors(['name' => 'The provided credentials do not match our records.']);
            }
        }        return redirect()->back()->withErrors(['name' => 'The provided credentials do not match our records.']);

    }


    /**
     * Display the specified resource.
     */
    public function show(login $login)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(login $login)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, login $login)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(login $login)
    {
        //
    }
    public function logout(Request $request){
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        elseif (auth()->check()) {
            Auth::logout();
            return redirect()->route('auth.login');
        }
    }
}
