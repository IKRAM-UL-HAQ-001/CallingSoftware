<?php

namespace App\Http\Controllers;

use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class PhoneNumberController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->where('role', '!=', 'assistant')->get();
        $PhoneNumbers = PhoneNumber::all();
        return view('admin.phone_number.list', compact('users', 'PhoneNumbers'));
    }

    public function assistantIndex()
    {
        $users = User::all();
        $PhoneNumbers = PhoneNumber::all();
        return view('assistant.phone_number.list', compact('users', 'PhoneNumbers'));
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
    public function fileStore(Request $request)
    {

        $request->validate([
            'encrypted_file_data' => 'required|json', 
            'user_id' => 'required',
        ]);
    
        // Decode the JSON array of encrypted phone numbers
        $encryptedNumbers = json_decode($request->input('encrypted_file_data'), true);
        
        if (empty($encryptedNumbers)) {
            return back()->with('error', 'No valid phone numbers received.');
        }
    
        $phoneNumbers = [];
        $duplicateNumbers = [];
        $exchange_id = User::where('id', $request->user_id)->value('exchange_id');

        foreach ($encryptedNumbers as $encryptedPhone) {
            // Decrypt each phone number
            $decryptedPhoneNumber = $encryptedPhone; // Implement decryptData as shown below
    
            // Validate the decrypted phone number
            $validator = Validator::make(['phone_number' => $decryptedPhoneNumber], [
                'phone_number' => 'required', // Adjust validation as needed
            ]);
    
            if ($validator->passes()) {
                // Check if phone number already exists in the database
                if (!PhoneNumber::where('phone_number', $decryptedPhoneNumber)->exists()) {
                    $phoneNumbers[] = [
                        'phone_number' => $decryptedPhoneNumber,
                        'user_id' => $request->user_id, 
                        'exchange_id' => $exchange_id, 
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                } else {
                    // Add to duplicate list if it already exists
                    $duplicateNumbers[] = $decryptedPhoneNumber;
                }
            }
        }
    
        // Insert all new phone numbers
        if (!empty($phoneNumbers)) {
            PhoneNumber::insert($phoneNumbers);
        }
    
        // Flash message for duplicates if any
        if (count($duplicateNumbers) > 0) {
            $duplicateCount = count($duplicateNumbers);
            $duplicates = implode(', ', $duplicateNumbers);
            session()->flash('success', "There were {$duplicateCount} duplicate entries that were not added: {$duplicates}");
        } else {
            session()->flash('success', 'All phone numbers were added successfully.');
        }
    
        return redirect()->route('admin.phone_number.list');
    }
    public function formStore(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'phone_number' => 'required'
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
    
        try {
            $secretKey = 'MRikram@#@2024!';
            // Decrypt user_id and phone
            $encryptedUserId = $request->input('user_id');
            $encryptedPhone = $request->input('phone_number');
            $exchange_id = User::where('id', $encryptedUserId)->value('exchange_id');
            // Check if the phone number already exists
            $existingPhoneNumber = PhoneNumber::where('phone_number', $encryptedPhone)->first();
            if ($existingPhoneNumber) {
                return response()->json(['error' => 'Duplicate phone number. This phone number already exists.'], 409);
            }
    
            // Store the data using Eloquent ORM
            $phoneNumber = new PhoneNumber();
            $phoneNumber->user_id = $encryptedUserId;
            $phoneNumber->phone_number = $encryptedPhone;
            $phoneNumber->exchange_id = $exchange_id;
            $phoneNumber->save();
    
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
     




    /**
     * Display the specified resource.
     */
    public function show(PhoneNumber $phoneNumber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhoneNumber $phoneNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhoneNumber $phoneNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhoneNumber $phoneNumber)
    {
        //
    }
}
