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
        $CustomerCares = User::where('role', 'customercare')->where('exchange_id',$request->id)->get();
        return view('admin.customer_care.list', compact('CustomerCares', 'Exchanges'));
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
            $user->save();

            return redirect()->route('admin.customercare_exchange.list');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }



    public function exchangeIndex()
    {
        $Exchanges = Exchange::all();
        return view('admin.customer_care.exchangelist',compact('Exchanges'));
    }

    public function customerCareIndex()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalNoOfCallDaily = NoOfCall::whereDate('created_at', $today)->count();
        $TotalDemoSendDaily = DemoSend::whereDate('created_at', $today)->count();
        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalFollowUpDaily = FollowUp::whereDate('created_at', $today)->count();
        $TotalReferIdDaily = ReferId::whereDate('created_at', $today)->count();
        $TotalRejectDaily = Reject::whereDate('created_at', $today)->count();
        $TotalWalkDaily = Walk::whereDate('created_at', $today)->count();

        // Monthly metrics
        $TotalPhoneNumberMonthly = PhoneNumber::whereMonth('created_at', $currentMonth)->count();
        $TotalNoOfCallMonthly = NoOfCall::whereMonth('created_at', $currentMonth)->count();
        $TotalDemoSendMonthly = DemoSend::whereMonth('created_at', $currentMonth)->count();
        $TotalFollowUpMonthly = FollowUp::whereMonth('created_at', $currentMonth)->count();
        $TotalReferIdMonthly = ReferId::whereMonth('created_at', $currentMonth)->count();
        $TotalRejectMonthly = Reject::whereMonth('created_at', $currentMonth)->count();
        $TotalWalkMonthly = Walk::whereMonth('created_at', $currentMonth)->count();

        // Prepare dashboard data
        $dailyData = [
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Reject Daily ", 'value' => $TotalRejectDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Walk-ins ", 'value' => $TotalWalkDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Referred IDs ", 'value' => $TotalReferIdDaily, 'icon' => "ni ni-badge"],
            ['label' => "Demos Sent ", 'value' => $TotalDemoSendDaily, 'icon' => "ni ni-email-83"],
            ['label' => "Follow Ups ", 'value' => $TotalFollowUpDaily, 'icon' => "ni ni-chat-round"],
        ];

        $monthlyData = [
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Demos Sent  ", 'value' => $TotalDemoSendMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Follow Ups  ", 'value' => $TotalFollowUpMonthly, 'icon' => "ni ni-time-alarm"],
            ['label' => "Referred IDs  ", 'value' => $TotalReferIdMonthly, 'icon' => "ni ni-collection"],
            ['label' => "Rejections  ", 'value' => $TotalRejectMonthly, 'icon' => "ni ni-folder-remove"],
            ['label' => "Walk-ins  ", 'value' => $TotalWalkMonthly, 'icon' => "ni ni-chart-bar-32"]
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
    public function destroy(CustomerCare $customerCare)
    {
        //
    }
}
