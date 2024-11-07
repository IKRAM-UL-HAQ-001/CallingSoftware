<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PhoneNumber;
use App\Models\NoOfCall;
use App\Models\Exchange;
use App\Models\Customer;
use App\Models\DemoSend;
use App\Models\Complaint;
use App\Models\FollowUp;
use App\Models\ReferId;
use App\Models\Reject;
use App\Models\TotalCall;
use App\Models\TotalAmount;
use App\Models\Walk;
use App\Models\NewId;
use Carbon\Carbon;
use Auth;
use DB;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Exchanges = Exchange::all();
        return view('admin.exchange.list',compact('Exchanges'));
    }

    public function exchnageUsers(Request $request)
    {
        $Users = User::where('role', 'exchange')->where('exchange_id',$request->id)->get();
        
        return view('admin.exchange.userlist',compact('Users'));
    }

    function decryptData($encryptedData) {
        // Set the same key and IV used in CryptoJS
        $key = 'MRikam@#@2024!XY'; // Ensure this matches the key used in CryptoJS (16 bytes for AES-128)
        $iv = hex2bin('00000000000000000000000000000000'); // Convert hex IV to binary
    
        // Decode the base64 encoded data from CryptoJS
        $encryptedData = base64_decode($encryptedData);
    
        // Decrypt using OpenSSL with AES-128-CBC and PKCS7 padding
        $decryptedData = openssl_decrypt($encryptedData, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    
        return $decryptedData; // Return decrypted data as a string
    }

    public function popDashboard(Request $request)
    {   
        $userId = $request->id;
        $exchangeId = $request->exchange_id;
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();
        
        $TotalNoOfCallDaily = PhoneNumber::whereDate('created_at', $today)
        ->where('exchange_id',$exchangeId)
        ->where('status','deactive')
        ->where('user_id',$userId)
        ->count();
        
        $TotalDemoSendDaily = DemoSend::whereDate('created_at', $today)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();
        
        $TotalFollowUpDaily = FollowUp::whereDate('created_at', $today)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();
        
        $TotalReferIdDaily = ReferId::whereDate('created_at', $today)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();
        
        $TotalRejectDaily = Reject::whereDate('created_at', $today)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();

        $TotalWalkDaily = Walk::whereDate('created_at', $today)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();

        $TotalNewIdDaily = NewId::whereDate('created_at', $today)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();

        $TotalComplaintDaily = Complaint::whereMonth('created_at', $today)
        ->whereYear('created_at', $currentYear)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();


        $encryptedAmountsDaily = DB::table(DB::raw("(
            SELECT amount FROM complaints WHERE DATE(created_at) = CURDATE() AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM demo_sends WHERE DATE(created_at) = CURDATE() AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM follow_ups WHERE DATE(created_at) = CURDATE() AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM new_ids WHERE DATE(created_at) = CURDATE() AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM refer_ids WHERE DATE(created_at) = CURDATE() AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM rejects WHERE DATE(created_at) = CURDATE() AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM walks WHERE DATE(created_at) = CURDATE() AND exchange_id = $exchangeId AND user_id = $userId
        ) as combined"))
        ->pluck('amount');

        $encryptedAmountsMonthly = DB::table(DB::raw("(
            SELECT amount FROM complaints WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM demo_sends WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM follow_ups WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM new_ids WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM refer_ids WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM rejects WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear AND exchange_id = $exchangeId AND user_id = $userId
            UNION ALL
            SELECT amount FROM walks WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear AND exchange_id = $exchangeId AND user_id = $userId
        ) as combined"))
        ->pluck('amount');
    
        $TotalAmountDaily = 0;
    
        $TotalAmountMonthly = 0;
        // Decrypt and sum the amounts
        foreach ($encryptedAmountsDaily as $encryptedAmount) {
            $decryptedAmount = $this->decryptData($encryptedAmount); // Decrypt each amount
            $TotalAmountDaily += (float)$decryptedAmount; // Sum the decrypted amount
        }
        foreach ($encryptedAmountsMonthly as $encryptedAmount) {
            $decryptedAmount = $this->decryptData($encryptedAmount); // Decrypt each amount
            $TotalAmountMonthly += (float)$decryptedAmount; // Sum the decrypted amount
        }
        // Monthly metrics
        $TotalPhoneNumberMonthly = PhoneNumber::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();
        
        $TotalNoOfCallMonthly = PhoneNumber::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('status','deactive')
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();
        
        $TotalDemoSendMonthly = DemoSend::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();
        
        $TotalFollowUpMonthly = FollowUp::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();

        $TotalReferIdMonthly = ReferId::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();
        
        $TotalRejectMonthly = Reject::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();
        
        $TotalWalkMonthly = Walk::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();

        $TotalNewIdMonthly = NewId::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();

        $TotalComplaintMonthly = Complaint::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('exchange_id',$exchangeId)
        ->where('user_id',$userId)
        ->count();

        $dailyData = [
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Demos Sent ", 'value' => $TotalDemoSendDaily, 'icon' => "ni ni-email-83"],
            ['label' => "Follow Ups ", 'value' => $TotalFollowUpDaily, 'icon' => "ni ni-chat-round"],
            ['label' => "Referred IDs ", 'value' => $TotalReferIdDaily, 'icon' => "ni ni-badge"],
            ['label' => "Reject ", 'value' => $TotalRejectDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Walk-Ins ", 'value' => $TotalWalkDaily, 'icon' => "ni ni-user-run"],
            ['label' => "New Id", 'value' => $TotalNewIdDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Complaint", 'value' => $TotalComplaintDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Amount", 'value' => $TotalAmountDaily, 'icon' => "ni ni-user-run"],
        ];

        $monthlyData = [
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberMonthly, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallMonthly, 'icon' => "ni ni-single-02"],
            ['label' => "Demos Sent  ", 'value' => $TotalDemoSendMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Follow Ups  ", 'value' => $TotalFollowUpMonthly, 'icon' => "ni ni-time-alarm"],
            ['label' => "Referred IDs  ", 'value' => $TotalReferIdMonthly, 'icon' => "ni ni-collection"],
            ['label' => "Reject  ", 'value' => $TotalRejectMonthly, 'icon' => "ni ni-folder-remove"],
            ['label' => "Walk-ins  ", 'value' => $TotalWalkMonthly, 'icon' => "ni ni-chart-bar-32"],
            ['label' => "New Id ", 'value' => $TotalNewIdMonthly, 'icon' => "ni ni-user-run"],
            ['label' => "Complaint", 'value' => $TotalComplaintMonthly, 'icon' => "ni ni-user-run"],
            ['label' => "Amount", 'value' => $TotalAmountMonthly, 'icon' => "ni ni-user-run"],
        ];
        
        return response()->json([
            'dailyData' => $dailyData,
            'monthlyData' => $monthlyData
        ]);
    }

    public function assistantIndex()
    {
        $Exchanges = Exchange::all();
        return view('assistant.exchange.list',compact('Exchanges'));
    }

    public function store(Request $request)
    {
        {
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'exchange_name' => 'required|unique:exchanges,name',
            ]);
        
            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }
        
            try {
                $encryptedExchangeName = $request->input('exchange_name');        
        
                // Store the data using Eloquent ORM
                $exchange = new Exchange();
                $exchange->name = $encryptedExchangeName;
                $exchange->save();
        
                return redirect()->back();
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Exchange $exchange)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exchange $exchange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exchange $exchange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exchange $exchange)
    {
        //
    }
}
