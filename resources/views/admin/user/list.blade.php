@extends("layouts.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom mb-5">
                <h2 class="mb-0">Users </h2>
                <div>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#myModal">Add User</button>
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
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark">Exchange Name</th>
                                    <th class="text-center text-uppercase text-secondary font-weight-bolder text-dark">Action</th>
                                </tr>
                            </thead>

                            <tbody id="DataTableBody">
                                @foreach ($Users as $user)
                                <tr>
                                    <td style="width: 45%;" class="encrypted-data">{{ $user->user_name }}</td>
                                    <td style="width: 45%;" class="encrypted-data">{{ $user->exchange->name }}</td>
                                    <td style="width: 10%; text-align: center;">
                                        <button class="btn btn-danger btn-sm" onclick="deleteId(this)">Delete</button>
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

<!-- Add New Number Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="myModalLabel" style="color:white">Add New Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success text-white" id='success' style="display:none;"></div>
                <div class="alert alert-danger text-white" id='error' style="display:none;"></div>
                <form id="form" method="post" action="{{ route('admin.user.formPost') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="editExchange" class="form-label">Exchange</label>
                        <select class="form-select px-3" id="editExchange" name="exchange_id">
                            <option value="" disabled selected>Select Exchange</option>
                            @foreach($Exchanges as $exchange)
                            <option value="{{ $exchange->id }}">{{ $exchange->name }}</option>
                            @endforeach
                        </select>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
<script>
    $(document).ready(function() {
        const secretKey = 'MRikam@#@2024!'; // The same key used for encryption

        // Decrypt data on page load
        $('.encrypted-data').each(function() {
            const encryptedData = $(this).text().trim();
            const decryptedData = CryptoJS.AES.decrypt(encryptedData, secretKey).toString(CryptoJS.enc.Utf8);
            $(this).text(decryptedData); // Update the text with the decrypted data
        });


        // Handle form submission via AJAX
        $('#form').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            // Get the phone number and user_id values from the form fields
            const user_name = $('#user_name').val();
            const password = $('#password').val();
            const exchange_id = $('#editExchange').val(); // Corrected to the right ID

            // Encrypt the user_name and password
            const encrypteduser_name = CryptoJS.AES.encrypt(user_name, 'MRikam@#@2024!').toString();
            const encryptedpassword = CryptoJS.AES.encrypt(password, 'MRikam@#@2024!').toString();
;
            // Create form data with encrypted user_name
            const formData = {
                user_name: encrypteduser_name,
                password: encryptedpassword,
                exchange_id: exchange_id,
                _token: '{{ csrf_token() }}'
            };

            // Send data via AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#success').show().text(response.success);
                        $('#DataTable').DataTable().ajax.reload(); // Reload data table to reflect changes
                        $('#myModal').modal('hide'); // Close the modal on success
                        $('#form')[0].reset(); // Reset the form fields
                    } else {
                        $('#error').show().text(response.error);
                    }
                },
                error: function() {
                    $('#error').show().text('An error occurred.');
                }
            });
        });
    });
</script>
@endsection
