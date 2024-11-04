@extends("layouts.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom mb-5">
                <h2 class="mb-0">Users</h2>
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
                                    <td style="width: 45%;" class=" ">{{ $user->exchange->name }}</td>
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
                <form id="form" method="post" action="{{ route('admin.user.formPost') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="editExchange" class="form-label">Exchange</label>
                        <select class="form-select px-3" id="editExchange" name="exchange_id">
                            <option value="" disabled selected>Select Exchange</option>
                            @foreach($Exchanges as $exchange)
                            <option value="{{ $exchange->id }}" class="exchange-option">{{ $exchange->name }}</option>
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
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>

<script>
    const secretKey = 'MRikam@#@2024!';
    const fixedIV = CryptoJS.enc.Hex.parse('00000000000000000000000000000000'); // Fixed IV for deterministic encryption

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

        $('#form').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const userName = $('#user_name').val();
            const exchangeId = $('#editExchange').val();
            const password = $('#password').val();

            const encryptedUserName = CryptoJS.AES.encrypt(userName, CryptoJS.enc.Utf8.parse(secretKey), { iv: fixedIV }).toString();
            const encryptedExchangeId = exchangeId; // Assuming exchange ID does not need encryption
            const encryptedPassword = CryptoJS.AES.encrypt(password, CryptoJS.enc.Utf8.parse(secretKey), { iv: fixedIV }).toString();

            $('#user_name').val(encryptedUserName);
            $('#editExchange').val(encryptedExchangeId);
            $('#password').val(encryptedPassword);

            this.submit();
        });
    });
        $('.encrypted-data').each(function() {
    const encryptedData = $(this).text().trim();
            // alert(encryptedData);
    if (encryptedData) {
        try {
            // Attempt to decrypt the data
            const decryptedBytes = CryptoJS.AES.decrypt(encryptedData, CryptoJS.enc.Utf8.parse(secretKey), { iv: fixedIV });
            const decryptedData = decryptedBytes.toString(CryptoJS.enc.Utf8);

            // Check if decryption returned a valid result
            if (decryptedData) {
                $(this).text(decryptedData); // Update the element's text with decrypted data
            } else {
                console.warn("Decryption resulted in an empty string. Check key or data format.");
            }
        } catch (error) {
            console.error("Error decrypting data:", error);
        }
    } else {
        console.warn("No data to decrypt.");
    }
});

</script>

@endsection
