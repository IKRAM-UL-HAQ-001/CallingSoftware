@extends("layouts.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom mb-5">
                <h2 class="mb-0">Phone Numbers</h2>
                <div>
                    <button type="button" class="btn btn-secondary ms-2" style="background: #344767;" data-bs-toggle="modal" data-bs-target="#fileModal">Upload Excel File</button>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#myModal">Add Number</button>
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
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark">Phone Number</th>
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark ps-2">User Name</th>
                                    <th class="text-center text-uppercase text-secondary font-weight-bolder text-dark">Action</th>
                                </tr>
                            </thead>

                            <tbody id="DataTableBody">
                                @foreach ($PhoneNumbers as $phoneNumber)
                                <tr>
                                    <td style="width: 45%;" class="encrypted-phone-number">{{ $phoneNumber->phone_number }}</td>
                                    <td style="width: 45%;">{{ $phoneNumber->user->name }}</td>
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
                <form id="form" method="post" action="{{ route('admin.phone_number.formPost') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="editExchange" class="form-label">Users</label>
                        <select class="form-select px-3" id="editExchange" name="user_id">
                            <option value="" disabled selected>Select User</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Phone Number</label>
                        <input type="text" class="form-control border px-3" id="phone_number" name="phone_number" placeholder="Enter Phone Number" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Number</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Upload File Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="fileModalLabel" style="color:white">Upload Excel File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" method="post" action="{{route('admin.phone_number.filePost')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="editExchange" class="form-label">Users</label>
                        <select class="form-select px-3" id="editExchange" required>
                            <option value="" disabled selected>Select User</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File</label>
                        <input type="file" class="form-control border px-3" id="file" name="file" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
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
<script>
    $(document).ready(function() {
        const displayedNumbers = new Set(); // Use a Set to track displayed numbers

        // Decrypt phone numbers on page load
        $('.encrypted-phone-number').each(function() {
            const encryptedNumber = $(this).text().trim();
            const secretKey = 'MRikam@#@2024!'; // The same key used for encryption
            const decryptedNumber = CryptoJS.AES.decrypt(encryptedNumber, secretKey).toString(CryptoJS.enc.Utf8);

            // Check if the number has already been displayed
            if (!displayedNumbers.has(decryptedNumber)) {
                $(this).text(decryptedNumber); // Update the text with the decrypted number
                displayedNumbers.add(decryptedNumber); // Add it to the displayed numbers
            } else {
                $(this).closest('tr').remove(); // Remove the row if the number is a duplicate
            }
        });

        // Handle form submission via AJAX
        $('#form').on('submit', function (e) {
            e.preventDefault(); // Prevent the form from submitting normally

            // Get the phone number and user_id values from the form fields
            const phone_number = $('#phone_number').val();
            const userId = $('#editExchange').val();

            // Encrypt the phone number
            const encryptedPhone = CryptoJS.AES.encrypt(phone_number, 'MRikam@#@2024!').toString();

            // Create form data with encrypted phone number
            const formData = {
                user_id: userId,
                phone_number: encryptedPhone,
                _token: '{{ csrf_token() }}'
            };

            // Send data via AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                if (response.success) {
        $('#success').show().text(response.message);
        $('#DataTable').DataTable().ajax.reload();
        $('#myModal').modal('hide');
        $('#form')[0].reset();
        setTimeout(function() { // Set a timeout function to hide the alert after 2 seconds
            $('#success').fadeOut('slow');
        }, 2000); // 2000 milliseconds = 2 seconds
    } else {
        $('#error').show().text(response.message);
        setTimeout(function() { // Hide error message after 2 seconds
            $('#error').fadeOut('slow');
        }, 2000);
    }
},
error: function() {
    $('#error').show().text('An error occurred.');
    setTimeout(function() { // Hide error message after 2 seconds
        $('#error').fadeOut('slow');
    }, 2000);
}
            });
    });
</script>
@endsection
