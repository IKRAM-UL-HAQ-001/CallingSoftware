
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl mt-5" style="margin-top:10px !important " id="navbarBlur" data-scroll="false">
<div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-12 me-5">
            @if(session()->has('user_role'))
                @switch(session('user_role'))
                    @case('admin')
                    <li class="breadcrumb-item text-sm">
                        <a class="text-white mb-2" href="javascript:void(0);">Admin</a>
                    </li>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
                    @break
                    @case('assistant')
                    <li class="breadcrumb-item text-sm">
                        <a class="text-white" href="javascript:void(0);">Assistant</a>
                    </li>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
                    @break
                    @case('exchange')
                        <li class="breadcrumb-item text-sm">
                            <a class="text-white" href="javascript:void(0);" style="font-size:18px">{{ session()->has('exchange') ?? 'No Exchange' }} Exchange Dashboard</a>
                        </li>
                        @break
                @endswitch
            @endif
        </ol>
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
        <ul class="navbar-nav align-items-center "> 
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
                @if(session()->has('user_role'))
                    @if(session('user_role')=== "admin")
                        <a href="javascript:void(0);" class="d-inline btn btn-danger mt-3" style="margin-right: 16px;" onclick="confirmLogout()">
                            Logout ALL
                        </a>
                        <a href="" class="d-inline btn btn-danger mt-3" style="margin-right: 16px;" onclick="confirmDownload()">
                            Download DATABASE
                        </a>
                    @endif
                @endif
                <a href="javascript:void(0);" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-sm-inline encrypted-data " style="color:white">{{ session('name') }}</span>
                    <i class="fa fa-user cursor-pointer" style="color:white; margin-left: 8px;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                    @if(session()->has('user_role'))
                        @if(session('user_role')=== "admin")
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="#" data-toggle="modal" data-target="#updatePasswordModal">
                                    <div class="d-flex align-items-center py-2">
                                        <i class="fas fa-lock me-2"></i>
                                        <div>
                                            <h6 class="text-sm font-weight-normal mb-0">
                                                <span class="font-weight-bold">Update Password</span>
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endif
                    <li class="mb-2">
                        <a class="dropdown-item border-radius-md" href="{{ route('login.logout') }}">
                            <div class="d-flex align-items-center py-2">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                <div>
                                    <h6 class="text-sm font-weight-normal mb-0">
                                        <span class="font-weight-bold">Logout</span>
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>

            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center"> 
                <a href="javascript:void(0);" class="nav-link p-0 text-body" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner"> 
                        <i class="sidenav-toggler-line"></i> 
                        <i class="sidenav-toggler-line"></i> 
                        <i class="sidenav-toggler-line"></i> 
                    </div> 
                </a> 
            </li>
        </ul>
    </div>
</div>
</nav>
<div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="updatePasswordModalLabel">Update Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="updatePasswordForm" method="POST">
                @csrf
                <div class="form-group">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder=" Enter Old Password" required>
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder=" Enter New Password" required>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitPasswordUpdate()">Update Password</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>

<script>
 $('.encrypted-data').each(function() {
            const encryptedData = $(this).text().trim();

            if (encryptedData) { // Check if data is non-empty
                try {
                    const decryptedData = CryptoJS.AES.decrypt(encryptedData, CryptoJS.enc.Utf8.parse(secretKey), { iv: fixedIV }).toString(CryptoJS.enc.Utf8);
                    if (decryptedData) {
                        $(this).text(decryptedData); // Display decrypted data
                    } else {
                        console.warn("Decryption failed. Empty result. Check key or data format.");
                    }
                } catch (error) {
                    console.error("Error decrypting data:", error);
                }
            } else {
                console.warn("No data to decrypt.");
            }
        });
    // });
// $(document).ready(function() {
//         const secretKey = 'MRikam@#@2024!'; // Consider moving this to server-side
//         $('.encrypted-data').each(function() {
//             const encryptedData = $(this).text().trim();
//             const decryptedData = CryptoJS.AES.decrypt(encryptedData, secretKey).toString(CryptoJS.enc.Utf8);
//             $(this).text(decryptedData);
//         });
//     });


function submitPasswordUpdate() {
    var formData = {
        currentPassword: $('#currentPassword').val(),
        newPassword: $('#newPassword').val(),
        _token: '{{ csrf_token() }}' // Ensure this token is included
    };

    $.ajax({
        url: '{{ route("password.update") }}', // Replace with your route
        type: 'POST',
        data: formData,
        success: function(response) {
            // Handle success (e.g., show a success message)
            alert('Password updated successfully!');
            $('#updatePasswordModal').modal('hide'); 
            location.reload(); 
        },
        error: function(xhr) {
            // Handle error (e.g., display error message)
            if (xhr.responseJSON && xhr.responseJSON.message) {
                alert(xhr.responseJSON.message);
            } else {
                alert('An error occurred while updating the password.');
            }
        }
    });
}
</script>
<script>
function confirmLogout() {
    if (confirm("Are you sure you want to log out of all users?")) {
        window.location.href = "{{ route('logout.all') }}";
    }
}
</script>
