@extends("layouts.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom mb-5">
                <h2 class="mb-0">Exchnages List</h2>
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
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark ps-2">Exchnage Name</th>
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark">Date and Time</th>
                                    <th class="text-center text-uppercase text-secondary font-weight-bolder text-dark">Action</th>
                                </tr>
                            </thead>
                            <tbody id="DataTableBody">
                                @foreach ($Exchanges as $exchange)
                                <tr>
                                    <td style="width: 45%;" class="encrypted-data">{{ $exchange->name }}</td>
                                    <td style="width: 45%;" class="encrypted-data">{{ $exchange->created_at }}</td>
                                    <td style="width: 10%; text-align: center;">
                                        <form action="{{ route('admin.customer_care.list') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" value="{{$exchange->id}}" name="id">
                                            <button type="submit" class="btn btn-danger btn-sm">Exchange user list</button>
                                        </form>
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


<!-- Add New User Modal -->
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
    function loadDashboard(id) {
        let formData = new FormData();
        formData.append('id', id);

        $.ajax({
            url: "{{ route('admin.customer_care.dashboard') }}", // Correct URL using named route
            type: 'GET'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , success: function(response) {
                let dailyMetricsHtml = '<h3 class="text-uppercase text-center mt-2 mb-2">Daily Metrics</h3><div class="row">';
                response.dailyData.forEach(function(item) {
                    dailyMetricsHtml += `
            <div class="col-xl-3 col-sm-6 mb-xl-0 my-4">
                <div class="card">
                    <div class="card-body p-3" style="background:#5e72e4 !important;border-radius:10px">
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

                let monthlyMetricsHtml = '<h3 class="text-uppercase text-center mt-5 mb-2">Monthly Metrics</h3><div class="row">';
                response.monthlyData.forEach(function(item) {
                    monthlyMetricsHtml += `
            <div class="col-xl-3 col-sm-6 mb-xl-0 my-4">
                <div class="card">
                    <div class="card-body p-3" style="background:#5e72e4 !important;border-radius:10px">
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

                // Insert the generated HTML into the modal body
                $('#dashboardModal .modal-body').html(dailyMetricsHtml + monthlyMetricsHtml);
                // Show the modal
                $('#dashboardModal').modal('show');
            },

            error: function() {
                alert('Failed to load the dashboard. Please try again.');
            }
        });
    }

</script>



@endsection
