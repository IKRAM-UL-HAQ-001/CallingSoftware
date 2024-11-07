@extends("layouts.main")

@section('content')
<div class="container-fluid py-4">
    <!-- Introductory banner -->
    <div class="row" >
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded text-center d-flex justify-content-center align-items-center" style="height:200px; height: 200px; background: url('{{ asset('assets/img/bg.png') }}') no-repeat center center; background-size: cover;">
            <h1 class="display-4 display-md-3 display-lg-2">Call Center Software</h1>        
        </div>
    </div>

    <!-- Daily Metrics Section -->
    <h3 class="text-uppercase text-center mt-5 mb-2">Daily Metrics</h3>
    <div class="row mt-5">
        @foreach ($dailyData as $data)
        <div class="col-xl-4 col-sm-6 mb-xl-0 my-4">
            <div class="card">
                <div class="card-body p-3" style="background:#acc301;border-radius:10px">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold" style="color: white">{{ $data['label'] }}</p>
                                <h5 class="font-weight-bolder" style="color: white">{{ $data['value'] }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape text-center rounded-circle" style="background-color: white">
                                <!-- Changed icon color to dark -->
                                <i class="{{ $data['icon'] }} text-lg text-dark" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Monthly Metrics Section -->
    <h3 class="text-uppercase text-center mt-5 mb-2">Monthly Metrics</h3>
    <div class="row mt-5">
        @foreach ($monthlyData as $data)
        <div class="col-xl-4 col-sm-6 mb-xl-0 my-4 ">
            <div class="card">
                <div class="card-body p-3" style="background:#acc301;border-radius:10px">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold" style="color: white">{{ $data['label'] }}</p>
                                <h5 class="font-weight-bolder" style="color: white">{{ $data['value'] }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape text-center rounded-circle" style="background-color: white">
                                <!-- Changed icon color to dark -->
                                <i class="{{ $data['icon'] }} text-lg text-dark opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
