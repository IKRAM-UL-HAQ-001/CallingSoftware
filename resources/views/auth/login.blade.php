<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    CallignSoftware
  </title>
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
    </div>
  </div>
  <main class="main-content  mt-0">
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
                  <!-- Display Validation Errors -->
                  @if ($errors->any())
                    <div class="alert alert-danger text-white">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  <form id="loginForm" role="form" method="post" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                      <select class="form-control form-control-lg" name="role" id="role" onchange="toggleExchangeDropdown()">
                        <option value="" disabled selected>Select your Role</option>
                        <option value="admin">Admin</option>
                        <option value="exchange">Exchange</option>
                        <option value="assistant">Assistant</option>
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
  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    function toggleExchangeDropdown() {
      const userRole = document.getElementById('role').value;
      const exchangeDropdown = document.getElementById('ExchangeDropdown');
      exchangeDropdown.style.display = (userRole === 'exchange') ? 'block' : 'none';
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>

</html>
