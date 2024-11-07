<?php

namespace App\Http\Controllers;

use App\Models\DemoSend;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemoSendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $DemoSends = DemoSend::all();
        return view ('admin.demo_send.list',compact('DemoSends'));
    }
    public function assistantIndex()
    {
        $DemoSends = DemoSend::all();
        return view ('assistant.demo_send.list',compact('DemoSends'));
    }
    public function exchangeIndex()
    {   
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $DemoSends = DemoSend::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)->get();
        return view('exchange.demo_send.list',compact('DemoSends'));
    }
    public function customercareIndex()
    {   
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $DemoSends = DemoSend::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)->get();
        return view('customer_care.demo_send.list',compact('DemoSends'));
    }


    public function create()
    {
        //
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
        
            $demoSend = new DemoSend();
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
    public function show(DemoSend $demoSend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DemoSend $demoSend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DemoSend $demoSend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DemoSend $demoSend)
    {
        //
    }
}
