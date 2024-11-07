<!DOCTYPE html>
<html lang="en">
@include("layouts.header")
<body class="g-sidenav-show">
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100vh; z-index: 0;">
        <div style="
            width: 100%; 
            height: 100%; 
            background-image: url('../assets/img/pxfuel.jpg'); 
            background-size: cover; 
            background-position: center; 
            opacity: 0.8;">
        </div>
    </div>   
    {{-- style="background:#5e72e4;" --}}
    <div class="min-height-300 position-absolute w-100" style="background:#acc301;"></div>
    @include("layouts.sideNavBar")
    <main class="main-content position-relative border-radius-lg pt-1">
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
