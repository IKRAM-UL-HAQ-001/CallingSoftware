@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom mb-5">
                    <h2 class="mb-0">Users</h2>
                    <div>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#myModal">Add
                            User</button>
                    </div>
                </div>

                <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center col-12">
                    <div class="card-body px-0 pb-2 px-3 col-12">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive p-0">
                            <table id="DataTable" class="table align-items-center mb-0 table-striped table-hover px-2">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary font-weight-bolder text-dark ps-2">User
                                            Name</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder text-dark">Exchange Name
                                        </th>
                                        <th class="text-center text-uppercase text-secondary font-weight-bolder text-dark">
                                            Permission</th>
                                        <th class="text-center text-uppercase text-secondary font-weight-bolder text-dark">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody id="DataTableBody">
                                    @foreach ($Users as $user)
                                        <tr>
                                            <td style="width: 45%;" class="encrypted-data">{{ $user->name }}</td>
                                            <td style="width: 45%;" class="encrypted-data ">
                                                {{ $user->exchange->name ?? 'No Exchange' }}</td>
                                            <td style="width: 20%; text-align: center;">
                                                <form action="{{ route('admin.user.status') }}" method="POST"
                                                    class="toggle-form">
                                                    @csrf
                                                    <input type="hidden" name="userId" value="{{ $user->id }}">
                                                    <input type="hidden" name="status" value="{{ $user->status }}">
                                                    <input type="checkbox" data-toggle="toggle"
                                                        {{ $user->status === 'active' ? 'checked' : '' }}
                                                        onchange="toggleStatus(this)">
                                                </form>
                                            </td>
                                            <td style="width: 10%; text-align: center;">
                                                <form method="POST" action="{{route('admin.user.delete')}}">
                                                    @csrf 
                                                    <input type="hidden" id="deleteIdInput" name="id" value="{{$user->id}}">
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="myModalLabel" style="color:white">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success text-white" id='success' style="display:none;"></div>
                    <div class="alert alert-danger text-white" id='error' style="display:none;"></div>
                    <form id="form" method="post" action="{{ route('admin.user.formPost') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="editExchange" class="form-label">Exchange</label>
                            <select class="form-select px-3" id="editExchange" name="exchange_id">
                                <option value="" disabled selected>Select Exchange</option>
                                @foreach ($Exchanges as $exchange)
                                    <option value="{{ $exchange->id }}" class="exchange-option encrypted-data">
                                        {{ $exchange->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="user_name" class="form-label">User Name</label>
                            <input type="text" class="form-control border px-3" id="user_name" name="user_name"
                                placeholder="Enter Username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control border px-3" id="password" name="password"
                                placeholder="Enter Password" required>
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Confirm jQuery and document ready are working
            console.log('Document ready');

            // Initialize bootstrap toggle for any checkboxes with data-toggle="toggle"
            $('[data-toggle="toggle"]').bootstrapToggle();

            // Encrypt form data on submit
            $('#form').on('submit', function(e) {
                e.preventDefault();
                const userName = encryptData($('#user_name').val());
                const password = encryptData($('#password').val());
                $('#user_name').val(userName);
                $('#password').val(password);
                this.submit();
            });

            // Handle change events for toggle checkboxes
            $('[id^="status-"]').on('change', function() {
                const userId = $(this).data('user-id');
                const status = $(this).prop('checked');
                console.log(
                    `Checkbox clicked for user ID: ${userId}, Status: ${status}`); // Debugging message

                togglePermission(userId, status); // Call the function to handle the update
            });
        });

        function toggleStatus(checkbox) {
            // Find the form associated with the checkbox
            const form = checkbox.closest('form');
            // Find the hidden status input field
            const statusInput = form.querySelector('input[name="status"]');
            // Toggle the status value
            statusInput.value = checkbox.checked ? 'active' : 'deactive';
            // Submit the form
            form.submit();
        }
    </script>
@endsection
