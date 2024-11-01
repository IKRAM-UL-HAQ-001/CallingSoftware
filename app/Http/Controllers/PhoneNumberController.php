<?php

namespace App\Http\Controllers;

use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
// use App\Http\Controllers\Validator;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PhoneNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $PhoneNumbers = PhoneNumber::all();
        return view('admin.phone_number.list', compact('users', 'PhoneNumbers'));
    }
    public function noOfCallIndex()
    {
        return view('admin.no_of_call.list');
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
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $data = Excel::toArray([], $request->file('file'));

        $phoneNumbers = [];
        $duplicateNumbers = [];

        foreach (array_slice($data[0], 1) as $row) { // Assuming data is in the first sheet
            $phoneNumber = $row[0];

            $validator = Validator::make(['phone_number' => $phoneNumber], [
                'phone_number' => 'required', // Adjust validation as per your needs
            ]);

            if ($validator->passes()) {
                // Check if phone number already exists in the database
                if (!PhoneNumber::where('phone_number', $phoneNumber)->exists()) {
                    $phoneNumbers[] = [
                        'phone_number' => $phoneNumber,
                        'user_id' => 1, // Set a default user_id or NULL
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                } else {
                    // Add to duplicate list if it already exists
                    $duplicateNumbers[] = $phoneNumber;
                }
            }
        }

        // Insert all new phone numbers
        PhoneNumber::insert($phoneNumbers);

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
