<?php

namespace App\Http\Controllers;

use App\Models\NewId;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewIdController extends Controller
{
    public function index()
    {
        $NewIds =  NewId::all();
        return view('admin.new_id.list',compact('NewIds'));
    }
    
    public function assistantIndex()
    {
        $NewIds =  NewId::all();
        return view('assistant.new_id.list',compact('NewIds'));
    }
    public function exchangeIndex()
    {   
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $NewIds = NewId::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)->get();
        return view('exchange.new_id.list',compact('NewIds'));
    }
    public function customercareIndex()
    {   
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $NewIds = NewId::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)->get();
        return view('customer_care.new_id.list',compact('NewIds'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'customer_name' => 'nullable',
            'customer_phone' => 'nullable',
            'customer_feedback' => 'nullable',
            'customer_amount' =>'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        try {
            $customer_name = $request->input('customer_name');
            $customer_phone = $request->input('customer_phone');
            $customer_feedback = $request->input('customer_feedback');
            $customer_amount = $request->input('customer_amount');
        
            $exchangeId = session('exchange_id');
            $userId = session('user_id');
            $PhoneId = $request->phone_id;
        
            $demoSend = new NewId();
            $demoSend->name = $customer_name;
            $demoSend->phone = $customer_phone;
            $demoSend->feedback = $customer_feedback;
            $demoSend->amount = $customer_amount;
            $demoSend->exchange_id = $exchangeId;
            $demoSend->user_id = $userId;
            $demoSend->save();
            
            $record = PhoneNumber::where('id', $PhoneId)
            ->where('user_id', $userId)
            ->where('exchange_id', $exchangeId)
            ->first();
            if ($record) {
                $record->status = 'deactive';
                $record->save();
            }
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NewId $newId)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewId $newId)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewId $newId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $newId = NewId::find($request->id);
        if ($newId) {
            $newId->delete();
            return redirect()->back()
            ->withHeaders([
                'X-Frame-Options' => 'DENY', // Prevents framing
                'Content-Security-Policy' => "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;"
            ]);
        }

        return redirect()->back()
        ->withHeaders([
            'X-Frame-Options' => 'DENY', // Prevents framing
            'Content-Security-Policy' => "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;"
        ]);
    }
}
