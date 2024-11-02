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
                                    <td style="width: 45%;" class="encrypted-data">{{ $user->name }}</td>
                                    <td style="width: 45%;" class="encrypted-data">{{ $user->exchange->name }}</td>
                                    <td style="width: 10%; text-align: center;">
                                        <button class="btn btn-danger btn-sm" onclick="deleteId(this)">Delete</button>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#DataTable').DataTable({
            pagingType: "full_numbers",
            order: [[0, 'desc']],
            language: {
                paginate: {
                    first: '«',
                    last: '»',
                    next: '›',
                    previous: '‹'
                }
            },
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10
        });

    });
</script>
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
