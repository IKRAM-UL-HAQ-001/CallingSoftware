@extends("layouts.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded text-center d-flex justify-content-center align-items-center" style="height:200px; background-image: url('public/assets/img/pattern-right.webp'); background-size: cover; background-position: center;">
            <h1 class="display-4 display-md-3 display-lg-2">Calling Management System</h1>        
        </div>
    </div>

    <h3 class="text-uppercase text-center mt-5 mb-2">Daily Metrics</h3>
    <div class="row mt-5 ">
        @foreach ($dailyData as $data)
        <div class="col-xl-4 col-sm-6 mb-xl-0 my-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ $data['label'] }}</p>
                                <h5 class="font-weight-bolder ">{{ $data['value'] }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-dark shadow-primary text-center rounded-circle">
                                <i class="{{ $data['icon'] }} text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h3 class="text-uppercase text-center mt-5 mb-2">Monthly Metrics</h3>
    <div class="row mt-5">
        @foreach ($monthlyData as $data)
            <div class="col-xl-4 col-sm-6 mb-xl-0 my-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ $data['label'] }}</p>
                                    <h5 class="font-weight-bolder">{{ $data['value'] }}</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="{{ $data['icon'] }} text-lg opacity-10" aria-hidden="true"></i>
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
