@extends("layouts.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom mb-5">
                <h2 class="mb-0">Exchanges</h2>
                <div>
                    <button type="button" class="btn btn-light text-white bg-dark" data-bs-toggle="modal" data-bs-target="#myModal">Add Exchange</button>
                </div>
            </div>
            <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center col-12">
                <div class="card-body px-0 pb-2 px-3 col-12">
                    <div class="table-responsive p-0">
                        <table id="DataTable" class="table align-items-center mb-0 table-striped table-hover px-2">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark">Exchange Name</th>
                                    <th class="text-center text-uppercase text-secondary font-weight-bolder text-dark">Action</th>
                                </tr>
                            </thead>
                            <tbody id="DataTableBody">
                                @foreach ($Exchanges as $exchange)
                                <tr data-exchange-id="{{ $exchange->id }}">
                                    <td style="width: 45%;" class="text-dark encrypted-data">{{ $exchange->name }}</td>
                                    <td style="width: 10%; text-align: center;">
                                        <form action="{{ route('admin.exchange.userlist') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" value="{{$exchange->id}}" name="id">
                                            <button type="submit" class="btn btn-danger btn-sm">Exchange user list</button>
                                        </form>
                                        <button class="btn btn-danger btn-sm" onclick="DeleteId(this)">Delete</button>
                                        <button class="btn btn-warning btn-sm" onclick="EditId(this)">Edit</button>
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

<!-- Add New Exchange Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center" style="background-color: #344767; color: white;">
                <h5 class="modal-title" id="myModalLabel">Add New Exchange</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success text-white" id='success' style="display:none;"></div>
                <div class="alert alert-danger text-white" id='error' style="display:none;"></div>
                <form id="form" method="post" action="{{ route('admin.exchange.formPost') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="exchange_name" class="form-label">Name</label>
                        <input type="text" class="form-control border px-3" id="exchange_name" name="exchange_name" placeholder="Enter Exchange Name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Exchange</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>


    $('#form').on('submit', function(e) {
        e.preventDefault();

        $('#exchange_name').val( encryptData($('#exchange_name').val())); // Use encryptData function
        this.submit();
    });

</script>

@endsection
