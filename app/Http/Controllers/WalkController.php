<?php

namespace App\Http\Controllers;

use App\Models\Walk;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Walks =  Walk::all();
        return view('admin.walk.list',compact('Walks'));
    }
    
    public function assistantIndex()
    {
        $Walks =  Walk::all();
        return view('assistant.walk.list',compact('Walks'));
    }
    public function exchangeIndex()
    {   
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $Walks = Walk::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)->get();
        return view('exchange.walk.list',compact('Walks'));
    }
    public function customercareIndex()
    {   
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $Walks = Walk::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)->get();
        return view('customer_care.walk.list',compact('Walks'));
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
        
            $demoSend = new Walk();
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
    public function show(Walk $walk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Walk $walk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Walk $walk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Walk $walk)
    {
        //
    }
}
