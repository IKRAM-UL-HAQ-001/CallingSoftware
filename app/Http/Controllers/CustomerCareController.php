<?php

namespace App\Http\Controllers;

use App\Models\CustomerCare;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\PhoneNumber;
use App\Models\NoOfCall;
use App\Models\User;
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


class CustomerCareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $Exchanges = Exchange::all();
        // $CustomerCares = User::where('role', 'customercare')
        // ->where('exchange_id', $request->id)
        // ->get();
        return view('admin.customer_care.exchangelist', compact('Exchanges'));
    }

    public function userlist(Request $request)
    {
        $CustomerCares = User::where('role', 'customercare')
        ->where('exchange_id', $request->id)
        ->get();
        return view('admin.customer_care.list', compact('CustomerCares'));
    }

    public function assistantIndex()
    {
        $CustomerCares = CustomerCare::all();
        return view('assistant.customer_care.list', compact('CustomerCares'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required',
            'exchange' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Get encrypted inputs
            $encryptedUserName = $request->input('user_name');
            $encryptedPassword = $request->input('password');
            $encryptedExchange = $request->input('exchange');

            // Store the data using Eloquent ORM
            $user = new User();
            $user->name = $encryptedUserName;
            $user->password = $encryptedPassword;
            $user->exchange_id = $encryptedExchange;
            $user->role = 'customercare';
            $user->status = 'active';
            $user->save();

            return redirect()->route('admin.customercare_exchange.list');
        } catch (\Exception $e) {
            return redirect()->back();
        }
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
            ['label' => "Demo Sent ", 'value' => $TotalDemoSendDaily, 'icon' => "ni ni-email-83"],
            ['label' => "Follow Ups ", 'value' => $TotalFollowUpDaily, 'icon' => "ni ni-chat-round"],
            ['label' => "Refer Ids ", 'value' => $TotalReferIdDaily, 'icon' => "ni ni-badge"],
            ['label' => "Reject ", 'value' => $TotalRejectDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Walk-Ins ", 'value' => $TotalWalkDaily, 'icon' => "ni ni-user-run"],
            ['label' => "New Id", 'value' => $TotalNewIdDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Complaint", 'value' => $TotalComplaintDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Amount", 'value' => $TotalAmountDaily, 'icon' => "ni ni-user-run"],
        ];

        $monthlyData = [
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberMonthly, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallMonthly, 'icon' => "ni ni-single-02"],
            ['label' => "Demo Sent  ", 'value' => $TotalDemoSendMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Follow Ups  ", 'value' => $TotalFollowUpMonthly, 'icon' => "ni ni-time-alarm"],
            ['label' => "Refer Ids  ", 'value' => $TotalReferIdMonthly, 'icon' => "ni ni-collection"],
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


    public function show(CustomerCare $customerCare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerCare $customerCare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerCare $customerCare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $customercare = User::find($request->id);
        if ($customercare) {
            $customercare->delete();
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
