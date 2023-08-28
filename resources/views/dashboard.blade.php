<?php

use Illuminate\Support\Facades\Cookie;

$username = Cookie::get('username');
if (!isset($username)) {
    header('Location: ' . route('admin.login'));
    exit; // Dừng thực hiện mã lệnh tiếp theo
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Harper 7 chuyên cung cấp các sản phẩm cà phê chất lượng, đồ uống tươi ngon cùng các loại bánh mì, bánh ngọt và set ăn đa dạng đáp ứng nhu cầu của quý khách">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="harper, harper 7, harper seven, coffee, bakery, roastery, breakfast, brunch, dinner, cà phê, bánh mì, bánh ngọt, ăn sáng ăn trưa, ăn tối, rang xay">
    <link rel="icon" href="https://www.harper7coffee.com/images/favicon.ico" type="image/x-icon">
    <title>{{$title}}</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('./back-end/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('./back-end/css/style.css')}}" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <!-- SwalAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.1/dist/sweetalert2.min.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
                <div class="sidebar-brand-text fs-16 mx-3">Harper 7</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <i class="fa-solid fa-house"></i>
                    <span>Trang chủ</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Thao tác
            </div>
            <!-- Role -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRole" aria-expanded="true" aria-controls="collapseRole">
                    <i class="fa-solid fa-briefcase"></i>
                    <span>Chức vụ</span>
                </a>
                <div id="collapseRole" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Các thao tác:</h6>
                        <a class="collapse-item" href="{{route('role.list')}}">Danh sách chức vụ</a>
                    </div>
                </div>
            </li>
            <!-- Account -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccount" aria-expanded="true" aria-controls="collapseAccount">
                    <i class="fa-solid fa-user"></i>
                    <span>Tài khoản</span>
                </a>
                <div id="collapseAccount" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Các thao tác:</h6>
                        <a class="collapse-item" href="{{route('account.list')}}">Danh sách tài khoản</a>
                    </div>
                </div>
            </li>
            <!-- Category -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
                    <i class="fa-solid fa-shop"></i>
                    <span>Danh mục</span>
                </a>
                <div id="collapseCategory" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Các thao tác:</h6>
                        <a class="collapse-item" href="{{route('category.list')}}">Danh sách danh mục</a>
                    </div>
                </div>
            </li>

            <!-- Product -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseProduct">
                    <i class="fa-solid fa-cake-candles"></i>
                    <span>Sản phẩm</span>
                </a>
                <div id="collapseProduct" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Các thao tác:</h6>
                        <a class="collapse-item" href="{{route('product.list')}}">Danh sách sản phẩm</a>
                    </div>
                </div>
            </li>

            <!-- Slide -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSlide" aria-expanded="true" aria-controls="collapseSlide">
                    <i class="fa-brands fa-adversal"></i>
                    <span>Quảng cáo</span>
                </a>
                <div id="collapseSlide" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Các thao tác:</h6>
                        <a class="collapse-item" href="{{route('slide.list')}}">Danh sách quảng cáo</a>
                    </div>
                </div>
            </li>

            <!-- Supplier -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa-solid fa-truck-field"></i>
                    <span>Nhà cung cấp</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Các thao tác:</h6>
                        <a class="collapse-item" href="{{route('supplier.list')}}">Danh sách nhà cung cấp</a>
                    </div>
                </div>
            </li>

            <!-- Customer -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer" aria-expanded="true" aria-controls="collapseCustomer">
                    <i class="fa-solid fa-user-tie"></i>
                    <span>Khách hàng</span>
                </a>
                <div id="collapseCustomer" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Các thao tác:</h6>
                        <a class="collapse-item" href="{{route('customer.list')}}">Danh sách khách hàng</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
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

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
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
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn muốn đăng xuất?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Bạn đồng ý đăng xuất tài khoản này!</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy bỏ</button>
                    <a class="btn btn-primary logout">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('./back-end/js/jquery.min.js')}}"></script>
    <script src="{{asset('./back-end/js/bootstrap.bundle.min.js')}}"></script>
    @if(request()->is('admin/category/list'))
    <script>
        var listParent = {
            !!json_encode($listParent) !!
        };
    </script>
    @elseif(request()->is('admin/product/list'))
    <script>
        var listCate = {
            !!json_encode($listCate) !!
        };
    </script>
    @elseif(request()->is('admin/gallery/list'))
    <script>
        var routeUpdateGallery = "{{route('gallery.update')}}";
    </script>
    @endif
    <script src="{{asset('./back-end/js/function.js')}}"></script>
    <script src="{{asset('./back-end/js/main.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('./back-end/js/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('./back-end/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.3/chart.min.js" integrity="sha512-fMPPLjF/Xr7Ga0679WgtqoSyfUoQgdt8IIxJymStR5zV3Fyb6B3u/8DcaZ6R6sXexk5Z64bCgo2TYyn760EdcQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- CKEditor -->
    <script src="//cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <!-- SwalAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.1/dist/sweetalert2.min.js"></script>
    <script>
        CKEDITOR.replace('ckeditor');
        CKEDITOR.replace('ckeditor1');
        CKEDITOR.config.pasteFormWordPromptCleanup = true;
        CKEDITOR.config.pasteFormWordRemoveFontStyles = false;
        CKEDITOR.config.pasteFormWordRemoveStyles = false;
        CKEDITOR.config.language = 'vi';
        CKEDITOR.config.htmlEncodeOutput = false;
        CKEDITOR.config.ProcessHTMLEntities = false;
        CKEDITOR.config.entities = false;
        CKEDITOR.config.entities_latin = false;
        CKEDITOR.config.ForceSimpleAmpersand = true;
        $(document).ready(function() {
            //dang xuat tai khoan
            $('.logout').click(function() {
                let url = "{{route('admin.logout')}}";
                let method = "GET";
                let data = {};
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                callAjax(url, method, data, headers,
                    function(data) {
                        if (data.res === 'success') {
                            location.href = '{{route("admin.login")}}'
                        }
                    },
                    function(err) {
                        console.log(err);
                    }
                );
            })
            //sua nha cung cap
            $('.update-supplier').on('click', function() {
                let url = "{{route('supplier.update')}}";
                let method = "POST";
                let data = {
                    id_supplier: $('.update-supplier').attr('data-id'),
                    name_supplier: $('.name-update').val(),
                    phone_supplier: $('.phone-update').val(),
                    address_supplier: $('.address-update').val(),
                }
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                callAjax(url, method, data, headers,
                    function(data) {
                        if (data.res === 'success' || data.res === 'error') {
                            $('.message-supplier').text(data.status);
                            if ($('.error-name').text() != '' || $('.error-phone').text() != '' || $('.error-address').text() != '') {
                                $('.error-name').text('');
                                $('.error-phone').text('');
                                $('.error-address').text('');
                            }
                        } else if (data.res === 'warning') {
                            $('.error-name').text(data.status.name ? data.status.name : '');
                            $('.error-phone').text(data.status.phone ? data.status.phone : '');
                            $('.error-address').text(data.status.address ? data.status.address : '');
                        }
                    },
                    function(err) {
                        console.log(err);
                    }
                );
            })
            //xoa nha cung cap
            $('#myTable').on('click', '.delete-supplier', function() {
                let name = $('.name-' + $(this).data('id')).text();
                let url = '{{route("supplier.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: $(this).data('id'),
                };
                swalQuestion('<span class="fs-16">Bạn có muốn xóa nhà cung cấp ' + name + ' không</span>', function(alert) {
                    if (alert) {
                        callAjax(url, method, data, headers,
                            function(data) {
                                if (data.res === 'success') {
                                    swalNotification('Xóa thành công!', 'Bạn đã xóa thành công.', 'success',
                                        function(callback) {
                                            if (callback) {
                                                location.reload();
                                            }
                                        }
                                    );
                                } else {
                                    swalNotification('Xóa không thành công!', 'Bạn đã xóa không thành công.', 'error');
                                }
                            },
                            function(err) {
                                console.log(err);
                            }
                        );
                    } else {}
                });
            })
            //sua danh muc
            $('.update-category').on('click', function() {
                let url = "{{route('category.update')}}";
                let method = "POST";
                let data = {
                    id_category: $('.update-category').attr('data-id'),
                    name_category: $('.name-update').val(),
                    id_parent_category: $('.id-parent-update').val(),
                }
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                callAjax(url, method, data, headers,
                    function(data) {
                        if (data.res === 'success' || data.res === 'error') {
                            $('.message-category').text(data.status);
                            if ($('.error-name').text() != '') {
                                $('.error-name').text('');
                            }
                        } else if (data.res === 'warning') {
                            $('.error-name').text(data.status.name ? data.status.name : '');
                        }
                    },
                    function(err) {
                        console.log(err);
                    }
                );
            })
            //xoa danh muc
            $('#myTable').on('click', '.delete-category', function() { // su kien click ben trong id myTable va bat click co class la delete-category
                let name = $('.name-' + $(this).data('id')).text();
                let url = '{{route("category.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: $(this).data('id'),
                };
                // console.log('a');
                swalQuestion('<span class="fs-16">Bạn có muốn xóa nhà danh mục ' + name + ' không</span>', function(alert) {
                    if (alert) {
                        callAjax(url, method, data, headers,
                            function(data) {
                                if (data.res === 'success') {
                                    swalNotification('Xóa thành công!', 'Bạn đã xóa thành công.', 'success',
                                        function(callback) {
                                            if (callback) {
                                                location.reload();
                                            }
                                        }
                                    );
                                } else {
                                    swalNotification('Xóa không thành công!', 'Bạn đã xóa không thành công.', 'error');
                                }
                            },
                            function(err) {
                                console.log(err);
                            }
                        );
                    } else {}
                });
            })
            //sua quang cao
            $('.update-slide').submit(function(e) {
                e.preventDefault()
                let url = "{{route('slide.update')}}";
                let method = "POST";
                let formData = new FormData($('.update-slide')[0]);
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

                callAjax(url, method, formData, headers,
                    function(data) {
                        if (data.res === 'success' || data.res === 'error') {
                            $('.message-slide').text(data.status);
                            if ($('.error-image').text() != '' || $('.error-name').text() != '' || $('.error-slug').text() != '') {
                                $('.error-name').text('');
                                $('.error-image').text('');
                                $('.error-slug').text('');
                            }
                        } else if (data.res === 'warning') {
                            $('.error-image').text(data.status.image_slide ? data.status.image_slide : '');
                            $('.error-name').text(data.status.name_slide ? data.status.name_slide : '');
                            $('.error-slug').text(data.status.slug_slide ? data.status.slug_slide : '');
                        }
                    },
                    function(err) {
                        console.log(err);
                    }, 1);
            })
            //xoa quang cao
            $('#myTable').on('click', '.delete-slide', function() { // su kien click ben trong id myTable va bat click co class la delete-category
                let name = $('.name-' + $(this).data('id')).text();
                let url = '{{route("slide.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: $(this).data('id'),
                };
                // console.log('a');
                swalQuestion('<span class="fs-16">Bạn có muốn xóa ảnh có tên là ' + name + ' không</span>', function(alert) {
                    if (alert) {
                        callAjax(url, method, data, headers,
                            function(data) {
                                if (data.res === 'success') {
                                    swalNotification('Xóa thành công!', 'Bạn đã xóa thành công.', 'success',
                                        function(callback) {
                                            if (callback) {
                                                location.reload();
                                            }
                                        }
                                    );
                                } else {
                                    swalNotification('Xóa không thành công!', 'Bạn đã xóa không thành công.', 'error');
                                }
                            },
                            function(err) {
                                console.log(err);
                            }
                        );
                    } else {}
                });
            })
            //sua san pham
            $('.update-product').submit(function(e) {
                e.preventDefault()
                let url = "{{route('product.update')}}";
                let method = "POST";
                let formData = new FormData($('.update-product')[0]);
                formData.append('description_product', CKEDITOR.instances['ckeditor'].getData())
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                callAjax(url, method, formData, headers,
                    function(data) {
                        if (data.res === 'success' || data.res === 'error') {
                            $('.message-product').text(data.status);
                            if ($('.error-image').text() != '' || $('.error-name').text() != '' || $('.error-subname').text() != '' ||
                                $('.error-quantity').text() != '' || $('.error-price').text() != '') {
                                $('.error-name').text('');
                                $('.error-image').text('');
                                $('.error-subname').text('');
                                $('.error-quantity').text('');
                                $('.error-price').text('');
                            }
                        } else if (data.res === 'warning') {
                            $('.error-image').text(data.status.image_product ? data.status.image_product : '');
                            $('.error-name').text(data.status.name_product ? data.status.name_product : '');
                            $('.error-subname').text(data.status.subname_product ? data.status.subname_product : '');
                            $('.error-quantity').text(data.status.quantity_product ? data.status.quantity_product : '');
                            $('.error-price').text(data.status.price_product ? data.status.price_product : '');
                        }
                    },
                    function(err) {
                        console.log(err);
                    }, 1);
            })
            //xoa san pham
            $('#myTable').on('click', '.delete-product', function() {
                let name = $('.name-' + $(this).data('id')).text();
                let url = '{{route("product.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: $(this).data('id'),
                };
                // console.log('a');
                swalQuestion('<span class="fs-16">Bạn có muốn xóa ảnh có tên là ' + name + ' không</span>', function(alert) {
                    if (alert) {
                        callAjax(url, method, data, headers,
                            function(data) {
                                if (data.res === 'success') {
                                    swalNotification('Xóa thành công!', 'Bạn đã xóa thành công.', 'success',
                                        function(callback) {
                                            if (callback) {
                                                location.reload();
                                            }
                                        }
                                    );
                                } else {
                                    swalNotification('Xóa không thành công!', 'Bạn đã xóa không thành công.', 'error');
                                }
                            },
                            function(err) {
                                console.log(err);
                            }
                        );
                    } else {}
                });
            })
            //xoa danh muc hinh anh san pham
            $('#myTable').on('click', '.delete-gallery', function() {
                let index = $(this).data('index');
                let url = '{{route("gallery.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: $(this).data('id'),
                };
                swalQuestion('<span class="fs-16">Bạn có muốn xóa ảnh số ' + index + ' không</span>', function(alert) {
                    if (alert) {
                        callAjax(url, method, data, headers,
                            function(data) {
                                if (data.res === 'success') {
                                    swalNotification('Xóa thành công!', 'Bạn đã xóa thành công.', 'success',
                                        function(callback) {
                                            if (callback) {
                                                location.reload();
                                            }
                                        }
                                    );
                                } else {
                                    swalNotification('Xóa không thành công!', 'Bạn đã xóa không thành công.', 'error');
                                }
                            },
                            function(err) {
                                console.log(err);
                            }
                        );
                    }
                });
            })
            //sua chuc vu
            $('.update-role').on('click', function() {
                let url = "{{route('role.update')}}";
                let method = "POST";
                let data = {
                    id_role: $('.update-role').attr('data-id'),
                    name_role: $('.name-update').val(),
                }
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                callAjax(url, method, data, headers,
                    function(data) {
                        if (data.res === 'success' || data.res === 'error') {
                            $('.message-role').text(data.status);
                            if ($('.error-name').text() != '') {
                                $('.error-name').text('');
                            }
                        } else if (data.res === 'warning') {
                            $('.error-name').text(data.status.name ? data.status.name : '');
                        }
                    },
                    function(err) {
                        console.log(err);
                    }
                );
            })
            //xoa chuc vu
            $('#myTable').on('click', '.delete-role', function() {
                let name = $('.name-' + $(this).data('id')).text();
                let url = '{{route("role.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: $(this).data('id'),
                };
                swalQuestion('<span class="fs-16">Bạn có muốn xóa chức vụ ' + name + ' không</span>', function(alert) {
                    if (alert) {
                        callAjax(url, method, data, headers,
                            function(data) {
                                if (data.res === 'success') {
                                    swalNotification('Xóa thành công!', 'Bạn đã xóa thành công.', 'success',
                                        function(callback) {
                                            if (callback) {
                                                location.reload();
                                            }
                                        }
                                    );
                                } else {
                                    swalNotification('Xóa không thành công!', 'Bạn đã xóa không thành công.', 'error');
                                }
                            },
                            function(err) {
                                console.log(err);
                            }
                        );
                    }
                });
            })
            //xoa tai khoan
            $('#myTable').on('click', '.delete-account', function() {
                let name = $('.name-' + $(this).data('id')).text();
                let url = '{{route("account.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: $(this).data('id'),
                };
                swalQuestion('<span class="fs-16">Bạn có muốn xóa tài khoản ' + name + ' này không</span>', function(alert) {
                    if (alert) {
                        callAjax(url, method, data, headers,
                            function(data) {
                                if (data.res === 'success') {
                                    swalNotification('Xóa thành công!', 'Bạn đã xóa thành công.', 'success',
                                        function(callback) {
                                            if (callback) {
                                                location.reload();
                                            }
                                        }
                                    );
                                } else {
                                    swalNotification('Xóa không thành công!', 'Bạn đã xóa không thành công.', 'error');
                                }
                            },
                            function(err) {
                                console.log(err);
                            }
                        );
                    }
                });
            })
        })
    </script>

</body>

</html>