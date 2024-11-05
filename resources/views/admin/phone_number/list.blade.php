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
                    <div class="alert alert-success" id="success-alert">
                        {{ session('success') }}
                    </div>
                    <script>
                        // Hide the success alert after 2 seconds (2000 milliseconds)
                        setTimeout(function() {
                            document.getElementById("success-alert").style.display = "none";
                        }, 2000);
                    </script>
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
                                    <td style="width: 45%;" class="encrypted-data">{{ $phoneNumber->phone_number }}</td>
                                    <td style="width: 45%;" class="encrypted-data">{{ $phoneNumber->user->name }}</td>
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
                            <option value="{{ $user->id }}" class="encrypted-data">{{ $user->name }}</option>
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
                        <label for="user_id" class="form-label">Users</label>
                        <select class="form-select px-3" id="user_id" name="user_id" required> 
                            <option value="" disabled selected>Select User</option>
                            @foreach($users as $user)
                                <option class="encrypted-data" value="{{ $user->id }}">{{ $user->name }}</option>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {
    $('#form').on('submit', function(e) {
        e.preventDefault();
        const encryptedNumber = encryptData($('#phone_number').val());
        $('#phone_number').val(encryptedNumber);
        this.submit();
    });



    document.getElementById("uploadForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        const fileInput = document.getElementById("file");
        const file = fileInput.files[0];
        if (!file) {
            alert("Please select a file to upload.");
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            // Assuming phone numbers are in the first column of the first sheet
            const sheet = workbook.Sheets[workbook.SheetNames[0]];
            const rows = XLSX.utils.sheet_to_json(sheet, { header: 1 });

            // Encrypt each phone number and prepare data for submission
            const encryptedNumbers = [];
            for (let i = 1; i < rows.length; i++) { // Skip header row
                const phoneNumber = rows[i][0];
                if (phoneNumber) {
                    const encryptedPhone = encryptData(phoneNumber.toString().trim());
                    encryptedNumbers.push(encryptedPhone);
                }
            }

            // Create a hidden input to hold the encrypted data array as JSON
            const encryptedInput = document.createElement("input");
            encryptedInput.type = "hidden";
            encryptedInput.name = "encrypted_file_data";
            encryptedInput.value = JSON.stringify(encryptedNumbers);

            fileInput.remove(); // Remove the original file input to avoid sending the unencrypted file

            document.getElementById("uploadForm").appendChild(encryptedInput);
            document.getElementById("uploadForm").submit();
        };

        reader.readAsArrayBuffer(file); // Read file as array buffer
    });
});
</script>
@endsection
