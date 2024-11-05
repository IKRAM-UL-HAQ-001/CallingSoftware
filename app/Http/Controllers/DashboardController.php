<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Models\User;
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

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Daily metrics
        $TotalExchange = Exchange::all()->count();
        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalNoOfCallDaily = phoneNumber::whereDate('created_at', $today)
        ->where('status','deactive')->count();
        $TotalUser = User::all()->count();
        $TotalRejectDaily = Reject::whereDate('created_at', $today)->count();
        $TotalWalkDaily = Walk::whereDate('created_at', $today)->count();
        $TotalComplaintDaily = Complaint::whereDate('created_at', $today)->count();
        $TotalReferIdDaily = ReferId::whereDate('created_at', $today)->count();
        $TotalDemoSendDaily = DemoSend::whereDate('created_at', $today)->count();
        $TotalFollowUpDaily = FollowUp::whereDate('created_at', $today)->count();
        $TotalAmountDaily = TotalAmount::whereDate('created_at', $today)->count();
        
        // Monthly metrics
        $TotalPhoneNumberMonthly = PhoneNumber::whereMonth('created_at', $currentMonth)->count();
        $TotalNoOfCallMonthly = phoneNumber::whereMonth('created_at', $currentMonth)
        ->where('status','deactive')->count();
        $TotalDemoSendMonthly = DemoSend::whereMonth('created_at', $currentMonth)->count();
        $TotalComplaintMonthly = Complaint::whereMonth('created_at', $currentMonth)->count();
        $TotalFollowUpMonthly = FollowUp::whereMonth('created_at', $currentMonth)->count();
        $TotalReferIdMonthly = ReferId::whereMonth('created_at', $currentMonth)->count();
        $TotalRejectMonthly = Reject::whereMonth('created_at', $currentMonth)->count();
        $TotalWalkMonthly = Walk::whereMonth('created_at', $currentMonth)->count();
        $TotalAmountMonthly = TotalAmount::whereMonth('created_at', $currentMonth)->count();

        // Prepare dashboard data
        $dailyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],
            ['label' => "Reject Daily ", 'value' => $TotalRejectDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Walk ", 'value' => $TotalWalkDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Complain ", 'value' => $TotalComplaintDaily, 'icon' => "ni ni-email-83"],
            ['label' => "Referred IDs ", 'value' => $TotalReferIdDaily, 'icon' => "ni ni-badge"],
            ['label' => "Demos Sent ", 'value' => $TotalDemoSendDaily, 'icon' => "ni ni-email-83"],  
            ['label' => "Follow Ups ", 'value' => $TotalFollowUpDaily, 'icon' => "ni ni-chat-round"],
            ['label' => "Amount ", 'value' => $TotalAmountDaily, 'icon' => "ni ni-chat-round"],
        ];

        $monthlyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],
            ['label' => "Reject  ", 'value' => $TotalRejectMonthly, 'icon' => "ni ni-folder-remove"],
            ['label' => "Walk  ", 'value' => $TotalWalkMonthly, 'icon' => "ni ni-chart-bar-32"],
            ['label' => "Complaint  ", 'value' => $TotalComplaintMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Referred IDs  ", 'value' => $TotalReferIdMonthly, 'icon' => "ni ni-collection"],
            ['label' => "Demos Sent  ", 'value' => $TotalDemoSendMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Follow Ups  ", 'value' => $TotalFollowUpMonthly, 'icon' => "ni ni-time-alarm"],
            ['label' => "Amount ", 'value' => $TotalAmountMonthly, 'icon' => "ni ni-support-16"],
        ];

        return view('admin.dashboard', compact('dailyData', 'monthlyData'));
    }

    
    public function assistantIndex()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Daily metrics
        $TotalExchange = Exchange::all()->count();
        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalNoOfCallDaily = NoOfCall::whereDate('created_at', $today)->count();
        $TotalUser = User::all()->count();

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
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],
            ['label' => "Reject Daily ", 'value' => $TotalRejectDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Walk-ins ", 'value' => $TotalWalkDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Referred IDs ", 'value' => $TotalReferIdDaily, 'icon' => "ni ni-badge"],
            ['label' => "Demos Sent ", 'value' => $TotalDemoSendDaily, 'icon' => "ni ni-email-83"],
            ['label' => "Follow Ups ", 'value' => $TotalFollowUpDaily, 'icon' => "ni ni-chat-round"],
        ];

        $monthlyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],

            ['label' => "Demos Sent  ", 'value' => $TotalDemoSendMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Follow Ups  ", 'value' => $TotalFollowUpMonthly, 'icon' => "ni ni-time-alarm"],
            ['label' => "Referred IDs  ", 'value' => $TotalReferIdMonthly, 'icon' => "ni ni-collection"],
            ['label' => "Rejections  ", 'value' => $TotalRejectMonthly, 'icon' => "ni ni-folder-remove"],
            ['label' => "Walk-ins  ", 'value' => $TotalWalkMonthly, 'icon' => "ni ni-chart-bar-32"]
        ];

        return view('assistant.dashboard', compact('dailyData', 'monthlyData'));
    }


    public function exchangeIndex()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $exchangeId =session('exchange_id');
        $userId =session('user_id');

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

        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)
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
        // Prepare dashboard data
        $dailyData = [
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Demos Sent ", 'value' => $TotalDemoSendDaily, 'icon' => "ni ni-email-83"],
            ['label' => "Follow Ups ", 'value' => $TotalFollowUpDaily, 'icon' => "ni ni-chat-round"],
            ['label' => "Referred IDs ", 'value' => $TotalReferIdDaily, 'icon' => "ni ni-badge"],
            ['label' => "Reject ", 'value' => $TotalRejectDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Walk-Ins ", 'value' => $TotalWalkDaily, 'icon' => "ni ni-user-run"],
            ['label' => "New Ids ", 'value' => $TotalNewIdDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Complaint", 'value' => $TotalComplaintDaily, 'icon' => "ni ni-user-run"],
        ];

        $monthlyData = [
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberMonthly, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallMonthly, 'icon' => "ni ni-single-02"],
            ['label' => "Demos Sent  ", 'value' => $TotalDemoSendMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Follow Ups  ", 'value' => $TotalFollowUpMonthly, 'icon' => "ni ni-time-alarm"],
            ['label' => "Referred IDs  ", 'value' => $TotalReferIdMonthly, 'icon' => "ni ni-collection"],
            ['label' => "Reject  ", 'value' => $TotalRejectMonthly, 'icon' => "ni ni-folder-remove"],
            ['label' => "Walk-ins  ", 'value' => $TotalWalkMonthly, 'icon' => "ni ni-chart-bar-32"],
            ['label' => "New Ids ", 'value' => $TotalNewIdMonthly, 'icon' => "ni ni-user-run"],
            ['label' => "Complaint", 'value' => $TotalComplaintMonthly, 'icon' => "ni ni-user-run"],
        ];

        return view('exchange.dashboard', compact('dailyData', 'monthlyData'));
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
        return view('customer_care.dashboard',compact('dailyData', 'monthlyData'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AdminDashboard $adminDashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdminDashboard $adminDashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdminDashboard $adminDashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminDashboard $adminDashboard)
    {
        //
    }
}
