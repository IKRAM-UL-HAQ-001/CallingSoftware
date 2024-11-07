@extends("layouts.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom mb-5">
                <h2 class="mb-0">Exchange Customer Care List</h2>
                <div>
                    {{-- <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#myModal">Add Customer Care</button> --}}
                </div>
            </div>
            <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center col-12">
                <div class="card-body px-0 pb-2 px-3 col-12">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="table-responsive p-0">
                        <table id="DataTable" class="table align-items-center mb-0 table-striped table-hover px-2">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark ps-2">User Name</th>
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark">Date and Time</th>
                                    <th class="text-center text-uppercase text-secondary font-weight-bolder text-dark">Action</th>
                                </tr>
                            </thead>
                            <tbody id="DataTableBody">
                                @foreach ($CustomerCares as $CustomerCare)
                                <tr>
                                    <td style="width: 45%;" class="encrypted-data">{{ $CustomerCare->name }}</td>
                                    <td style="width: 45%;" class="encrypted-data">{{ $CustomerCare->created_at }}</td>
                                    {{-- class="d-flex flex-wrap justify-content-center" --}}
                                    <td style="width: 10%; text-align: center;" >
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#dashboardModal" onclick="loadDashboard({{ $CustomerCare->id }},{{ $CustomerCare->exchange_id }})" style="background:#acc301;">Dashboard</button>
                                        <button class="btn btn-danger btn-sm text-white bg-dark" >Excel Daily</button>
                                        <button class="btn btn-danger btn-sm text-white bg-dark" >Excel Weekly</button>
                                        <button class="btn btn-danger btn-sm text-white bg-dark" >Excel Monthly</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="myModalLabel" style="color:white">Add New Customer Care</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success text-white" id='success' style="display:none;"></div>
                <div class="alert alert-danger text-white" id='error' style="display:none;"></div>
                <form id="form" method="post" action="{{ route('admin.customer_care.formPost') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="exchange" class="form-label">Exchange</label>
                        
                    </div>
                    <div class="mb-3">
                        <label for="user_name" class="form-label">User Name</label>
                        <input type="text" class="form-control border px-3" id="user_name" name="user_name" placeholder="Enter Username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control border px-3" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dashboardModal" tabindex="-1" aria-labelledby="dashboardModalLabel" aria-hidden="true" style="z-index:99999;">
    <div class="modal-dialog" style="max-width: 90%; z-index:99999;">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="dashboardModalLabel" style="color:white">Customer Care dashboard</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Encrypt form data before submitting
        $('#form').on('submit', function(e) {
            e.preventDefault();
            const userName = encryptData($('#user_name').val());
            const password = encryptData($('#password').val());
            $('#user_name').val(userName);
            $('#password').val(password);
            this.submit();
        });
    });

    // Function to load the dashboard with ID
    function loadDashboard(id, exchangeId) {
    let formData = new FormData();
    formData.append('id', id);
    formData.append('exchange_id', exchangeId);

    $.ajax({
        url: "{{ route('admin.customer_care.popUpDashboard') }}",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response); // Log response to inspect data format

            // Check if dailyData and monthlyData exist in the response
            if (response.dailyData && response.monthlyData) {
                let dailyMetricsHtml = '<h3 class="text-uppercase text-center mt-2 mb-2" style=" font-weight:bold">Daily Metrics</h3><div class="row">';
                response.dailyData.forEach(function(item) {
                    dailyMetricsHtml += `
                        <div class="col-xl-3 col-sm-6 mb-xl-0 my-4">
                            <div class="card">
                                <div class="card-body p-3" style="background:#acc301;border-radius:10px; font-weight:bold;">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">${item.label}</p>
                                                <h5 class="font-weight-bolder text-white">${item.value}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape text-primary shadow-primary text-center rounded-circle" style="background-color: white;">
                                                <i class="${item.icon} text-lg opacity-10" style="color:#5e72e4;" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                dailyMetricsHtml += '</div>';

                let monthlyMetricsHtml = '<h3 class="text-uppercase text-center mt-5 mb-2" style="font-weight:bold">Monthly Metrics</h3><div class="row">';
                response.monthlyData.forEach(function(item) {
                    monthlyMetricsHtml += `
                        <div class="col-xl-3 col-sm-6 mb-xl-0 my-4">
                            <div class="card">
                                <div class="card-body p-3" style="background:#acc301 !important;border-radius:10px; font-weight:bold;">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">${item.label}</p>
                                                <h5 class="font-weight-bolder text-white">${item.value}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape shadow-primary text-center rounded-circle" style="background-color: white;">
                                                <i class="${item.icon} text-primary text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                monthlyMetricsHtml += '</div>';

                // Insert generated HTML into the modal body
                $('#dashboardModal .modal-body').html(dailyMetricsHtml + monthlyMetricsHtml);
            } else {
                $('#dashboardModal .modal-body').html('<p>No data available</p>');
            }

            // Show the modal
            $('#dashboardModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); // Log detailed error information
            alert('Failed to load the dashboard. Please try again.');
        }
    });
}

</script>

@endsection