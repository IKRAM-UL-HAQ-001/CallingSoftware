<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="" target="_blank">
        <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">Demo project</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        @if(Auth::check())
            @if(Auth::user()->role === "admin")
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.dashboard')}}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.user.list') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.user.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                            </div>
                            <span class="nav-link-text ms-1">User</span>
                        </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.exchange.list') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.exchange.list')}}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">store</i>
                        </div>
                        <span class="nav-link-text ms-1">Exchange</span>
                    </a>
                </li>

            @endif
            @if(Auth::user()->role === "exchange")
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('exchange.dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{route('exchange.dashboard')}}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>              
            @endif
            @if(Auth::user()->role === "carecenter")
                <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('care_center.dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{route('care_center.dashboard')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('carecenter/complain')  ? 'active bg-gradient-primary' : '' }}" href="{{route('care_center.complain.list')}}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">report_problem</i>
                        </div>
                        <span class="nav-link-text ms-1">Complaint</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('carecenter/followup')  ? 'active bg-gradient-primary' : '' }}" href="{{route('care_center.follow_up.list')}}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">check_circle</i>
                        </div>
                        <span class="nav-link-text ms-1">Follow Up</span>
                    </a>
                </li>
            @endif
        @endif
      </ul>
    </div>
  </aside>