@extends("layouts.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom mb-5">
                <h2 class="mb-0">Exchange List</h2>
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
        $('#form').on('submit', function(e) {
            e.preventDefault();
            const userName = encryptData($('#user_name').val());
            const password = encryptData($('#password').val());
            $('#user_name').val(userName);
            $('#password').val(password);
            this.submit();
        });
    });
</script>
@endsection
