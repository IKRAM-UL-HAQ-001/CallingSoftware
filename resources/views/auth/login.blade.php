<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CallignSoftware</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your User Name and password to sign in</p>
                </div>
                <div class="card-body">
                  @if ($errors->any())
                    <div class="alert alert-danger text-white">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  <form id="form" method="post" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                      <select class="form-control form-control-lg" name="role" id="role" onchange="toggleExchangeDropdown()">
                        <option value="" disabled selected>Select your Role</option>
                        <option value="admin">Admin</option>
                        <option value="exchange">Exchange</option>
                        <option value="assistant">Assistant</option>
                        <option value="customer_care">Customer Care</option>
                      </select>
                    </div>
                    <div id="userFields">
                      <div class="mb-3">
                        <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Enter User Name" required>
                      </div>
                      <div class="mb-3">
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter Password" required>
                      </div>
                    </div>
                    <div id="ExchangeDropdown" style="display: none;">
                      <div class="mb-3">
                        <select class="form-control form-control-lg" id="exchange" name="exchange">
                          <option value="" disabled selected>Select Your Exchange</option>
                          @foreach($exchangeRecords as $exchange)
                            <option value="{{ $exchange->id ?? 'N/A' }}">{{ $exchange->name ?? 'N/A' }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script>
    $(document).ready(function() {
        const secretKey = 'MRikam@#@2024!';
        const fixedIV = CryptoJS.enc.Hex.parse('00000000000000000000000000000000'); // Fixed IV for deterministic encryption
        
        $('#form').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Encrypt the user_name and password fields
            const userName = $('#name').val();
            const exchangeId = $('#exchange').val(); // Correct reference to the exchange select
            const password = $('#password').val();

            const encryptedUserName = CryptoJS.AES.encrypt(userName, CryptoJS.enc.Utf8.parse(secretKey), { iv: fixedIV }).toString();
            const encryptedExchangeId = exchangeId; // Assuming exchange ID does not need encryption
            const encryptedPassword = CryptoJS.AES.encrypt(password, CryptoJS.enc.Utf8.parse(secretKey), { iv: fixedIV }).toString();

            // Set the encrypted values to the fields before submission
            $('#name').val(encryptedUserName);
            $('#exchange').val(encryptedExchangeId); // Update to use the correct ID
            $('#password').val(encryptedPassword);
            
            // Submit the form
            this.submit();
        });

        // Decrypt data on load
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
    });

    // Define the toggleExchangeDropdown function
    function toggleExchangeDropdown() {
        const role = document.getElementById('role').value;
        const exchangeDropdown = document.getElementById('ExchangeDropdown');
        
        if (role === 'exchange') {
            exchangeDropdown.style.display = 'block';
        } else {
            exchangeDropdown.style.display = 'none';
        }
    }
  </script>
</body>
</html>
