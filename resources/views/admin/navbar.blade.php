<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ isset($username) ? $username : ''}}
                </span>
                <img class="img-profile rounded-circle" src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Hồ sơ
                </a>
                <a class="dropdown-item" href="{{route('account.setting')}}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cài đặt
                </a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Đăng xuất
                </a>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow">
            <a href="#" class="nav-link dropdown-toggle" id="notification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <i class="fa-regular fa-bell fs-20"></i>
                    @if($dot)
                    <i class="fa-solid fa-circle text-danger fs-10 dot-bell position-relative" style="top: -10px; left: -12px;"></i>
                    @endif
                </span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in overflow-auto notification" style="height: 520px; width: 25rem !important;" aria-labelledby="notification">
                @foreach($notifications as $noti)
                <div class="border-bottom px-2 pt-2 choose-notification cursor-pointer" data-id="{{$noti->id_notification}}">
                    <a href="{{$noti->link}}" class="text-decoration-none">
                        <div class="d-flex align-item-center justify-content-between mb-1">
                            <span class="fs-12 d-block text-secondary">{{date('d/m/Y',strtotime($noti->created_at))}}</span>
                            @if($noti->is_read == 0)
                            <i class="fa-solid fa-circle text-danger fs-10 dot-notification"></i>
                            @endif
                        </div>
                        <p class="fs-15 text-dark">{{$noti->content}}</p>
                    </a>
                </div>
                @endforeach
                <span class="text-center fs-15 d-block mt-2 load-more-notification cursor-pointer" data-page="0"><i class="fa-solid fa-angle-down"></i> Xem thêm</span>
            </div>
        </li>

    </ul>

</nav>