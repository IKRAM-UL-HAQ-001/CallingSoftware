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
    public function index()
    {
        $Exchanges = Exchange::all();
        $Users = User::whereNotIn('role', ['admin', 'assistant'])
            ->get();
        return view('admin.user.list',compact('Exchanges','Users'));
    }

    public function assistantIndex()
    {
        $Users = User::whereNotIn('role', ['admin', 'assistant'])
            ->with('exchange')
            ->get();
        return view('assistant.user.list',compact('Users'));
    }

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

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function userStatus(Request $request)
    {
        $user = User::find($request->userId);

        $user->status = $request->status;
        $user->save();

        return redirect()->back();
    }
}
