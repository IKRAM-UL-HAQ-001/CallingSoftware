<?php

namespace App\Http\Controllers;

use App\Models\ReferId;
use Illuminate\Http\Request;
use App\Models\PhoneNumber;
use Illuminate\Support\Facades\Validator;

class ReferIdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ReferIds = ReferId::all();
        return view('admin.refer_id.list',compact('ReferIds'));
    }
    
    public function assistantIndex()
    {
        $ReferIds = ReferId::all();
        return view('assistant.refer_id.list',compact('ReferIds'));
    }
    public function exchangeIndex()
    {   
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $ReferIds = ReferId::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)->get();
        return view('exchange.refer_id.list',compact('ReferIds'));
    }

    public function customercareIndex()
    {   
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $ReferIds = ReferId::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)->get();
        return view('customer_care.refer_id.list',compact('ReferIds'));
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
        
            $demoSend = new ReferId();
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
    public function show(ReferId $referId)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReferId $referId)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReferId $referId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $referId = ReferId::find($request->id);
        if ($referId) {
            $referId->delete();
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
