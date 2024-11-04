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
use App\Models\FollowUp;
use App\Models\ReferId;
use App\Models\Reject;
use App\Models\TotalCall;
use App\Models\Walk;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = now();
        $startOfMonth = now()->startOfMonth();

        // Daily metrics
        $TotalExchange = Exchange::all()->count();
        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalNoOfCallDaily = NoOfCall::whereDate('created_at', $today)->count();
        $TotalUser = User::all()->count();
        $TotalCustomerDaily = Customer::whereDate('created_at', $today)->count();
        $TotalRejectDaily = Reject::whereDate('created_at', $today)->count();
        $TotalWalkDaily = Walk::whereDate('created_at', $today)->count();
        $TotalReferIdDaily = ReferId::whereDate('created_at', $today)->count();
        $TotalDemoSendDaily = DemoSend::whereDate('created_at', $today)->count();
        $TotalCallsDaily = TotalCall::whereDate('created_at', $today)->count();
        $TotalFollowUpDaily = FollowUp::whereDate('created_at', $today)->count();
        
        
        
        
        // Monthly metrics
        $TotalPhoneNumberMonthly = PhoneNumber::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalNoOfCallMonthly = NoOfCall::whereBetween('created_at', [$startOfMonth, $today])->count();

        $TotalCustomerMonthly = Customer::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalDemoSendMonthly = DemoSend::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalFollowUpMonthly = FollowUp::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalReferIdMonthly = ReferId::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalRejectMonthly = Reject::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalCallsMonthly = TotalCall::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalWalkMonthly = Walk::whereBetween('created_at', [$startOfMonth, $today])->count();

        // Prepare dashboard data
        $dailyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],
            ['label' => "Customers ", 'value' => $TotalCustomerDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Reject Daily ", 'value' => $TotalRejectDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Walk-ins ", 'value' => $TotalWalkDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Referred IDs ", 'value' => $TotalReferIdDaily, 'icon' => "ni ni-badge"],
            ['label' => "Demos Sent ", 'value' => $TotalDemoSendDaily, 'icon' => "ni ni-email-83"],
            ['label' => "Total Calls ", 'value' => $TotalCallsDaily, 'icon' => "ni ni-mobile-button"],
            ['label' => "Follow Ups ", 'value' => $TotalFollowUpDaily, 'icon' => "ni ni-chat-round"],
        ];

        $monthlyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],

            ['label' => "Customers  ", 'value' => $TotalCustomerMonthly, 'icon' => "ni ni-calendar-grid-58"],
            ['label' => "Demos Sent  ", 'value' => $TotalDemoSendMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Follow Ups  ", 'value' => $TotalFollowUpMonthly, 'icon' => "ni ni-time-alarm"],
            ['label' => "Referred IDs  ", 'value' => $TotalReferIdMonthly, 'icon' => "ni ni-collection"],
            ['label' => "Rejections  ", 'value' => $TotalRejectMonthly, 'icon' => "ni ni-folder-remove"],
            ['label' => "Total Calls  ", 'value' => $TotalCallsMonthly, 'icon' => "ni ni-support-16"],
            ['label' => "Walk-ins  ", 'value' => $TotalWalkMonthly, 'icon' => "ni ni-chart-bar-32"]
        ];

        return view('admin.dashboard', compact('dailyData', 'monthlyData'));
    }

    
    public function assistantIndex()
    {
        $today = now();
        $startOfMonth = now()->startOfMonth();

        // Daily metrics
        $TotalExchange = Exchange::all()->count();
        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalNoOfCallDaily = NoOfCall::whereDate('created_at', $today)->count();
        $TotalUser = User::all()->count();

        $TotalCustomerDaily = Customer::whereDate('created_at', $today)->count();
        $TotalDemoSendDaily = DemoSend::whereDate('created_at', $today)->count();
        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalFollowUpDaily = FollowUp::whereDate('created_at', $today)->count();
        $TotalReferIdDaily = ReferId::whereDate('created_at', $today)->count();
        $TotalRejectDaily = Reject::whereDate('created_at', $today)->count();
        $TotalCallsDaily = TotalCall::whereDate('created_at', $today)->count();
        $TotalWalkDaily = Walk::whereDate('created_at', $today)->count();

        // Monthly metrics
        $TotalPhoneNumberMonthly = PhoneNumber::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalNoOfCallMonthly = NoOfCall::whereBetween('created_at', [$startOfMonth, $today])->count();

        $TotalCustomerMonthly = Customer::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalDemoSendMonthly = DemoSend::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalFollowUpMonthly = FollowUp::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalReferIdMonthly = ReferId::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalRejectMonthly = Reject::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalCallsMonthly = TotalCall::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalWalkMonthly = Walk::whereBetween('created_at', [$startOfMonth, $today])->count();

        // Prepare dashboard data
        $dailyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],
            ['label' => "Customers ", 'value' => $TotalCustomerDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Reject Daily ", 'value' => $TotalRejectDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Walk-ins ", 'value' => $TotalWalkDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Referred IDs ", 'value' => $TotalReferIdDaily, 'icon' => "ni ni-badge"],
            ['label' => "Demos Sent ", 'value' => $TotalDemoSendDaily, 'icon' => "ni ni-email-83"],
            ['label' => "Total Calls ", 'value' => $TotalCallsDaily, 'icon' => "ni ni-mobile-button"],
            ['label' => "Follow Ups ", 'value' => $TotalFollowUpDaily, 'icon' => "ni ni-chat-round"],
        ];

        $monthlyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],

            ['label' => "Customers  ", 'value' => $TotalCustomerMonthly, 'icon' => "ni ni-calendar-grid-58"],
            ['label' => "Demos Sent  ", 'value' => $TotalDemoSendMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Follow Ups  ", 'value' => $TotalFollowUpMonthly, 'icon' => "ni ni-time-alarm"],
            ['label' => "Referred IDs  ", 'value' => $TotalReferIdMonthly, 'icon' => "ni ni-collection"],
            ['label' => "Rejections  ", 'value' => $TotalRejectMonthly, 'icon' => "ni ni-folder-remove"],
            ['label' => "Total Calls  ", 'value' => $TotalCallsMonthly, 'icon' => "ni ni-support-16"],
            ['label' => "Walk-ins  ", 'value' => $TotalWalkMonthly, 'icon' => "ni ni-chart-bar-32"]
        ];

        return view('assistant.dashboard', compact('dailyData', 'monthlyData'));
    }


    public function exchangeIndex()
    {
        $today = now();
        $startOfMonth = now()->startOfMonth();

        // Daily metrics
        $TotalExchange = Exchange::all()->count();
        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalNoOfCallDaily = NoOfCall::whereDate('created_at', $today)->count();
        $TotalUser = User::all()->count();

        $TotalCustomerDaily = Customer::whereDate('created_at', $today)->count();
        $TotalDemoSendDaily = DemoSend::whereDate('created_at', $today)->count();
        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalFollowUpDaily = FollowUp::whereDate('created_at', $today)->count();
        $TotalReferIdDaily = ReferId::whereDate('created_at', $today)->count();
        $TotalRejectDaily = Reject::whereDate('created_at', $today)->count();
        $TotalCallsDaily = TotalCall::whereDate('created_at', $today)->count();
        $TotalWalkDaily = Walk::whereDate('created_at', $today)->count();

        // Monthly metrics
        $TotalPhoneNumberMonthly = PhoneNumber::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalNoOfCallMonthly = NoOfCall::whereBetween('created_at', [$startOfMonth, $today])->count();

        $TotalCustomerMonthly = Customer::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalDemoSendMonthly = DemoSend::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalFollowUpMonthly = FollowUp::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalReferIdMonthly = ReferId::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalRejectMonthly = Reject::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalCallsMonthly = TotalCall::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalWalkMonthly = Walk::whereBetween('created_at', [$startOfMonth, $today])->count();

        // Prepare dashboard data
        $dailyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],
            ['label' => "Customers ", 'value' => $TotalCustomerDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Reject Daily ", 'value' => $TotalRejectDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Walk-ins ", 'value' => $TotalWalkDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Referred IDs ", 'value' => $TotalReferIdDaily, 'icon' => "ni ni-badge"],
            ['label' => "Demos Sent ", 'value' => $TotalDemoSendDaily, 'icon' => "ni ni-email-83"],
            ['label' => "Total Calls ", 'value' => $TotalCallsDaily, 'icon' => "ni ni-mobile-button"],
            ['label' => "Follow Ups ", 'value' => $TotalFollowUpDaily, 'icon' => "ni ni-chat-round"],
        ];

        $monthlyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],

            ['label' => "Customers  ", 'value' => $TotalCustomerMonthly, 'icon' => "ni ni-calendar-grid-58"],
            ['label' => "Demos Sent  ", 'value' => $TotalDemoSendMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Follow Ups  ", 'value' => $TotalFollowUpMonthly, 'icon' => "ni ni-time-alarm"],
            ['label' => "Referred IDs  ", 'value' => $TotalReferIdMonthly, 'icon' => "ni ni-collection"],
            ['label' => "Rejections  ", 'value' => $TotalRejectMonthly, 'icon' => "ni ni-folder-remove"],
            ['label' => "Total Calls  ", 'value' => $TotalCallsMonthly, 'icon' => "ni ni-support-16"],
            ['label' => "Walk-ins  ", 'value' => $TotalWalkMonthly, 'icon' => "ni ni-chart-bar-32"]
        ];

        return view('user.dashboard', compact('dailyData', 'monthlyData'));
    }

    


    public function customerCareIndex()
    {
        $today = now();
        $startOfMonth = now()->startOfMonth();

        // Daily metrics
        $TotalExchange = Exchange::all()->count();
        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalNoOfCallDaily = NoOfCall::whereDate('created_at', $today)->count();
        $TotalUser = User::all()->count();

        $TotalCustomerDaily = Customer::whereDate('created_at', $today)->count();
        $TotalDemoSendDaily = DemoSend::whereDate('created_at', $today)->count();
        $TotalPhoneNumberDaily = PhoneNumber::whereDate('created_at', $today)->count();
        $TotalFollowUpDaily = FollowUp::whereDate('created_at', $today)->count();
        $TotalReferIdDaily = ReferId::whereDate('created_at', $today)->count();
        $TotalRejectDaily = Reject::whereDate('created_at', $today)->count();
        $TotalCallsDaily = TotalCall::whereDate('created_at', $today)->count();
        $TotalWalkDaily = Walk::whereDate('created_at', $today)->count();

        // Monthly metrics
        $TotalPhoneNumberMonthly = PhoneNumber::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalNoOfCallMonthly = NoOfCall::whereBetween('created_at', [$startOfMonth, $today])->count();

        $TotalCustomerMonthly = Customer::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalDemoSendMonthly = DemoSend::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalFollowUpMonthly = FollowUp::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalReferIdMonthly = ReferId::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalRejectMonthly = Reject::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalCallsMonthly = TotalCall::whereBetween('created_at', [$startOfMonth, $today])->count();
        $TotalWalkMonthly = Walk::whereBetween('created_at', [$startOfMonth, $today])->count();

        // Prepare dashboard data
        $dailyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],
            ['label' => "Customers ", 'value' => $TotalCustomerDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Reject Daily ", 'value' => $TotalRejectDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Walk-ins ", 'value' => $TotalWalkDaily, 'icon' => "ni ni-user-run"],
            ['label' => "Referred IDs ", 'value' => $TotalReferIdDaily, 'icon' => "ni ni-badge"],
            ['label' => "Demos Sent ", 'value' => $TotalDemoSendDaily, 'icon' => "ni ni-email-83"],
            ['label' => "Total Calls ", 'value' => $TotalCallsDaily, 'icon' => "ni ni-mobile-button"],
            ['label' => "Follow Ups ", 'value' => $TotalFollowUpDaily, 'icon' => "ni ni-chat-round"],
        ];

        $monthlyData = [
            ['label' => "Exchanges", 'value' => $TotalExchange, 'icon' => "ni ni-single-02"],
            ['label' => "Phone Number", 'value' => $TotalPhoneNumberDaily, 'icon' => "ni ni-single-02"],
            ['label' => "No Of Call", 'value' => $TotalNoOfCallDaily, 'icon' => "ni ni-single-02"],
            ['label' => "Users ", 'value' => $TotalUser, 'icon' => "ni ni-single-02"],

            ['label' => "Customers  ", 'value' => $TotalCustomerMonthly, 'icon' => "ni ni-calendar-grid-58"],
            ['label' => "Demos Sent  ", 'value' => $TotalDemoSendMonthly, 'icon' => "ni ni-bell-55"],
            ['label' => "Follow Ups  ", 'value' => $TotalFollowUpMonthly, 'icon' => "ni ni-time-alarm"],
            ['label' => "Referred IDs  ", 'value' => $TotalReferIdMonthly, 'icon' => "ni ni-collection"],
            ['label' => "Rejections  ", 'value' => $TotalRejectMonthly, 'icon' => "ni ni-folder-remove"],
            ['label' => "Total Calls  ", 'value' => $TotalCallsMonthly, 'icon' => "ni ni-support-16"],
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
