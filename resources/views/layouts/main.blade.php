<!DOCTYPE html>
<html lang="en">
    @include("layouts.header")
    <body class="g-sidenav-show   bg-gray-100">
      <div class="min-height-300 bg-dark position-absolute w-100"></div>
        @include("layouts.sideNavBar")
        <main class="main-content position-relative border-radius-lg ">
            @include("layouts.topNavBar")        
            @yield("content")
            @include("layouts.footer")
        </main>
        <script src="../assets/js/core/popper.min.js"></script>
        <script src="../assets/js/core/bootstrap.min.js"></script>
        <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    </body>
</html>
