<?php

namespace App\Http\Controllers;

use App\Models\Reject;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RejectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Rejects = Reject::all();
        return view('admin.reject.list',compact('Rejects'));
    }

    public function assistantIndex()
    {
        $Rejects = Reject::all();
        return view('assistant.reject.list',compact('Rejects'));
    }
    public function exchangeIndex()
    {   
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $Rejects = Reject::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)->get();
        return view('exchange.reject.list',compact('Rejects'));
    }

    public function customercareIndex()
    {   
        $exchangeId = session('exchange_id');
        $userId = session('user_id');
        $Rejects = Reject::where('exchange_id', $exchangeId)
        ->where('user_id', $userId)->get();
        return view('customer_care.reject.list',compact('Rejects'));
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
        
            $demoSend = new Reject();
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
    public function show(Reject $reject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reject $reject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reject $reject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reject $reject)
    {
        //
    }
}
