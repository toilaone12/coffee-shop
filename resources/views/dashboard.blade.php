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
    @include('admin.head')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('admin.footer')
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
    @include('admin.logout')
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('./back-end/js/jquery.min.js')}}"></script>
    <script src="{{asset('./back-end/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('./back-end/js/function.js')}}"></script>
    <script src="{{asset('./back-end/js/main.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('./back-end/js/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('./back-end/js/sb-admin-2.min.js')}}"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- CKEditor -->
    <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <!-- SwalAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.1/dist/sweetalert2.min.js"></script>
    <!-- AutoNumeric -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>
    <!-- PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <!-- HTML2Canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if(request()->is('admin/category/list'))
    <script>
        var listParent = {!!json_encode($listParent) !!};
    </script>
    @elseif(request()->is('admin/product/list'))
    <script>
        var listCate = {!!json_encode($listCate) !!};
    </script>
    @elseif(request()->is('admin/gallery/list'))
    <script>
        var routeUpdateGallery = "{{route('gallery.update')}}";
    </script>
    @elseif(request()->is('admin/notes/list'))
    <script>
        var listUnit = {!!json_encode($listUnit) !!};
        var listSupplier = {!!json_encode($listSupplier) !!};
    </script>
    @elseif(request()->is('admin/ingredients/list'))
    <script>
        var listUnits = {!!json_encode($listUnits) !!};
    </script>
    @elseif(request()->is('admin/recipe/list'))
    <script>
        var listUnits = {!!json_encode($listUnits) !!};
        var listIngredients = {!!json_encode($listIngredients) !!};
        var listProducts = {!!json_encode($listProduct) !!};
    </script>
    @elseif(request()->is('admin/dashboard'))
    <script>
        $(document).ready(function() {
            var detail = {!!json_encode($arrDetail) !!};
            var arrName = [];
            var arrQuantity = [];
            detail.forEach(one => {
                arrName.push(one.name);
                arrQuantity.push(one.quantity);
            });
            // console.log(arrQuantity);
            var data = {
                labels: arrName, // truc x
                datasets: [{
                    label: 'Số lượng',
                    data: arrQuantity,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Màu nền của khu vực
                    borderColor: 'rgba(75, 192, 192, 1)', // Màu viền
                    borderWidth: 1
                }]
            };

            // Lấy thẻ canvas từ HTML
            var ctx = document.getElementById('myAreaChart').getContext('2d');

            // Tạo biểu đồ
            var myAreaChart = new Chart(ctx, {
                type: 'line', // Loại biểu đồ là khu vực
                data: data,
                options: {
                    // Cấu hình thêm nếu cần
                    scales: {
                        y: {
                            ticks: {
                                beginAtZero: true,
                                precision: 0 // Định dạng số nguyên
                            }
                        }
                    }
                }
            });
        })
    </script>
    @endif
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
    </script>
    <script>
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Phản hồi khách hàng',
            text: '{{ session('
            success ') }}',
        });
        @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Phản hồi khách hàng',
            text: '{{ session('
            error ') }}',
        });
        @endif
    </script>
    @include('admin.ajax')
</body>

</html>