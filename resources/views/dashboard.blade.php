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
        @include('admin.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.header')
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
    <!-- AutoNumeric -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>
    <!-- PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <!-- HTML2Canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            //xoa nhieu quang cao
            $('.delete-all-slide').click(function() {
                let arrId = [];
                let url = '{{route("slide.deleteAll")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let html = '<span class="fs-16">Bạn có muốn xóa quảng cáo';
                $('input[type="checkbox"]:checked').each(function(k, v) {
                    let id = parseInt($(this).val());
                    arrId.push({
                        id: id
                    });
                })
                html += ' không</span>';
                let data = {
                    arrId,
                };
                swalQuestion(html, function(alert) {
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
            //xoa nhieu chuc vu
            $('.delete-all-role').click(function() {
                let arrId = [];
                let url = '{{route("role.deleteAll")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let html = '<span class="fs-16">Bạn có muốn xóa chức vụ';
                $('input[type="checkbox"]:checked').each(function(k, v) {
                    let id = parseInt($(this).val());
                    arrId.push({
                        id: id
                    });
                })
                html += ' không</span>';
                let data = {
                    arrId,
                };
                swalQuestion(html, function(alert) {
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
            //sua don vi tinh
            $('.update-unit').on('click', function() {
                let url = "{{route('units.update')}}";
                let method = "POST";
                let data = {
                    id_unit: $('.update-unit').attr('data-id'),
                    fullname_unit: $('.fullname-update').val(),
                    abbreviation_unit: $('.abbreviation-update').val(),
                }
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                callAjax(url, method, data, headers,
                    function(data) {
                        if (data.res === 'success' || data.res === 'error') {
                            $('.message-unit').text(data.status);
                            if ($('.error-fullname').text() != '' || $('.error-abbreviation').text() != '') {
                                $('.error-fullname').text('');
                                $('.error-abbreviation').text('');
                            }
                        } else if (data.res === 'warning') {
                            $('.error-fullname').text(data.status.fullname ? data.status.fullname : '');
                            $('.error-abbreviation').text(data.status.abbreviation ? data.status.abbreviation : '');
                        }
                    },
                    function(err) {
                        console.log(err);
                    }
                );
            })
            //xoa don vi tinh
            $('#myTable').on('click', '.delete-unit', function() {
                let fullname = $('.fullname-' + $(this).data('id')).text();
                let url = '{{route("units.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: $(this).data('id'),
                };
                swalQuestion('<span class="fs-16">Bạn có muốn xóa đơn vị ' + fullname + ' này không</span>', function(alert) {
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
            //xoa nhieu don vi tinh
            $('.delete-all-unit').click(function() {
                let arrId = [];
                let url = '{{route("units.deleteAll")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let html = '<span class="fs-16">Bạn có muốn xóa chức vụ';
                $('input[type="checkbox"]:checked').each(function(k, v) {
                    let id = parseInt($(this).val());
                    arrId.push({
                        id: id
                    });
                })
                html += ' không</span>';
                let data = {
                    arrId,
                };
                swalQuestion(html, function(alert) {
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
            //them phieu hang
            $('.insert-note').submit(function(event) {
                event.preventDefault(); // Ngăn chặn việc gửi form mặc định;
                let url = "{{route('notes.insert')}}";
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let formData = new FormData($('.insert-note')[0]);
                formData.append('code_note',$('.list-detail-note').attr('data-code'))
                callAjax(url, method, formData, headers,
                    function(data) {
                        if(data.res === 'success' || data.res === 'fail'){
                            swalNotification(data.title, data.status, data.icon,
                                function(callback) {
                                    if (callback) {
                                        // Đóng modal hiện tại
                                        $('#exampleModal').modal('hide');                  
                                        // Mở modal khác
                                        $('#anotherModal').modal('show');
                                        $('.error-insert-name').text('');
                                        $('.error-insert-quantity').text('');
                                        listDetailNote(data.result);
                                    }
                                }
                            );
                        }else{
                            $('.error-insert-name').text(data.status.name_note);
                            $('.error-insert-quantity').text(data.status.quantity_note);
                        }
                    },
                    function(err) {
                        console.log(err);
                    }
                ,1)
            
            });
            //them danh sach chi tiet nguyen lieu
            $('.insert-detail-note').click(function(){
                let formDataArray = []; // Mảng chứa các dữ liệu từ form-detail-note
                $('.form-detail-note').each(function() {
                    //tim cac class co trong tung form-detail-note
                    let name = $(this).find('.name-ingredients-insert').val(); 
                    let unit = $(this).find('.id-unit-insert').val();
                    let quantity = $(this).find('.quantity-ingredients-insert').val();
                    let price = $(this).find('.price-ingredients-insert').val();
                    let formData = {
                        name_ingredient: name,
                        id_unit: unit,
                        quantity_ingredient: quantity,
                        price_ingredient: price
                    };
                    formDataArray.push(formData);
                });
                let url = "{{route('detail.insert')}}";
                let method = "POST";
                let header = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    name_note: $('.name-insert').val(),
                    quantity_note: $('.quantity-insert').val(),
                    id_supplier: $('.list-detail-note').attr('data-id'),
                    code_note: $('.list-detail-note').attr('data-code'),
                    formDataArray
                }
                callAjax(url,method,data,header,
                    function(data){
                        if(data.res === 'success' || data.res === 'fail'){
                            swalNotification(data.title, data.status, data.icon,
                                function(callback){
                                    $('.list-detail-note').attr('data-id','').attr('data-code','').attr('data-count','');
                                    location.reload();
                                }
                            )
                        }else{
                            $('.error-name').text(data.status.name);
                            $('.error-quantity').text(data.status.quantity);
                            $('.error-price').text(data.status.price);
                        }
                    },
                    function(err){
                        console.log(err);
                    })
            })
            //sua thong tin phieu hang va chuyen sang sua chi tiet phieu hang
            $('.update-note').submit(function(e){
                e.preventDefault();
                let url = "{{route('notes.update')}}";
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let formData = new FormData($('.update-note')[0]);
                formData.append('id',$('.update-note').attr('data-id'));
                callAjax(url, method, formData, headers,
                    function(data) {
                        if(data.res === 'success' || data.res === 'fail'){
                            swalNotification(data.title, data.status, data.icon,
                                function(callback) {
                                    if (callback) {
                                        $('#updateModal').modal('hide');                  
                                        // Mở modal khác
                                        $('#updateAnotherModal').modal('show');
                                        $('.error-update-name').text('');
                                        $('.error-update-quantity').text('');
                                        listUpdateDetailNote(data.result);
                                    }
                                }
                            );
                        }else{
                            $('.error-update-name').text(data.status.name_note);
                            $('.error-update-quantity').text(data.status.quantity_note);
                        }
                    },
                    function(err) {
                        console.log(err);
                    }
                ,1)
            })
            //sua danh sach chi tiet nguyen lieu
            $('.update-detail-note').click(function(){
                let formDataArray = []; // Mảng chứa các dữ liệu từ form-detail-note
                $('.form-update-detail-note').each(function() {
                    //tim cac class co trong tung form-detail-note
                    let name = $(this).find('.name-ingredients-update').val(); 
                    let unit = $(this).find('.id-unit-update').val();
                    let quantity = $(this).find('.quantity-ingredients-update').val();
                    let price = $(this).find('.price-ingredients-update').val();
                    let formData = {
                        name_ingredient: name,
                        id_unit: unit,
                        quantity_ingredient: quantity,
                        price_ingredient: price
                    };
                    formDataArray.push(formData);
                });
                let url = "{{route('detail.update')}}";
                let method = "POST";
                let header = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    name_note: $('.name-update').val(),
                    quantity_note: $('.quantity-update').val(),
                    id_supplier: $('.list-update-detail-note').attr('data-id'),
                    code_note: $('.list-update-detail-note').attr('data-code'),
                    formDataArray
                }
                callAjax(url,method,data,header,
                    function(data){
                        // console.log(data);
                        if(data.res === 'success' || data.res === 'fail'){
                            swalNotification(data.title, data.status, data.icon,
                                function(callback){
                                    $('.list-update-detail-note').attr('data-id','').attr('data-code','').attr('data-count','');
                                    location.reload();
                                }
                            )
                        }else{
                            $('.error-name').text(data.status.name);
                            $('.error-quantity').text(data.status.quantity);
                            $('.error-price').text(data.status.price);
                        }
                    },
                    function(err){
                        console.log(err);
                    }
                )
            })
            //xoa phieu hang
            $('#myTable').on('click', '.delete-note', function() {
                let name = $('.name-' + $(this).data('id')).text();
                let url = '{{route("notes.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: $(this).data('id'),
                };
                swalQuestion('<span class="fs-16">Bạn có muốn xóa ' + name + ' này không</span>', function(alert) {
                    if (alert) {
                        callAjax(url, method, data, headers,
                            function(data) {
                                // console.log(data);
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
            //xoa 1 nguyen lieu trong chi tiet don hang
            $('#myTable').on('click', '.delete-detail-note', function() {
                let name = $('.name-' + $(this).data('id')).text();
                let url = '{{route("detail.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: $(this).data('id'),
                };
                swalQuestion('<span class="fs-16">Bạn có muốn xóa nguyên liệu ' + name + ' này không</span>', function(alert) {
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
            //xuat nguyen lieu
            $('#myTable').on('click', '.export-ingredients', function() {
                let url = "{{route('detail.export')}}";
                let method = "GET";
                let data = {
                    id: $(this).data('id'),
                }
                let header = {};
                callAjax(url,method,data,header,
                    function(data){
                        swalNotification(data.title,data.status,data.icon,function(callback){
                            if(callback){
                                location.reload();
                            }
                        })
                    },
                    function(err){
                        console.log(err);      
                    }
                )
            })
            //sua nguyen lieu
            $('.update-ingredient').submit(function(e){
                e.preventDefault()
                let formData = new FormData($(this)[0]);
                let url = "{{route('ingredients.update')}}";
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                callAjax(url, method, formData, headers,
                    function(data) {
                        // console.log(data);
                        if (data.res === 'success' || data.res === 'error') {
                            swalNotification(data.title,data.text,data.icon,
                                function(callback){
                                    if(callback){
                                        location.reload();
                                        if ($('.error-name').text() != '') {
                                            $('.error-name').text('');
                                        }
                                    }
                                }
                            )
                        } else if (data.res === 'warning') {
                            $('.error-name').text(data.status.name_ingredient ? data.status.name_ingredient : '');
                        }
                    },
                    function(err) {
                        console.log(err);
                    }, 1);
            })
            //them cong thuc cho san pham
            $('.insert-recipe').click(function(){
                let objComponent = [];
                let url = "{{route('recipe.insert')}}";
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                $('.one-component').each(function(){
                    let obj = {
                        id_ingredient: $(this).find('.id-ingredient-insert').val(),
                        id_unit: $(this).find('.id-unit-insert').val(),
                        quantity_recipe_need: $(this).find('.quantity-insert').val(),
                    }
                    objComponent.push(obj);
                })
                let data = {
                    id_product: $('.id-product').val(),
                    objComponent
                }
                callAjax(url, method, data, headers,
                    function(data) {
                        swalNotification(data.title,data.status,data.icon,
                            function(callback) {
                                if (callback) {
                                    location.reload();
                                }
                            }
                        );
                    },
                    function(err) {
                        console.log(err);
                    }
                );
            })
            //sua cong thuc cho san pham
            $('.update-recipe').click(function(){
                let objComponent = [];
                let url = "{{route('recipe.update')}}";
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                $('.one-update-component').each(function(){
                    let obj = {
                        id_ingredient: $(this).find('.id-ingredient-update').val(),
                        id_unit: $(this).find('.id-unit-update').val(),
                        quantity_recipe_need: $(this).find('.quantity-update').val(),
                    }
                    objComponent.push(obj);
                })
                let data = {
                    id_product: $('.id-product-recipe').val(),
                    id_recipe: $('.id-recipe').val(),
                    objComponent
                }
                callAjax(url, method, data, headers,
                    function(data) {
                        swalNotification(data.title,data.status,data.icon,
                            function(callback) {
                                if (callback) {
                                    location.reload();
                                }
                            }
                        );
                    },
                    function(err) {
                        console.log(err);
                    }
                );
            });
            //xoa cong thuc cho san pham
            $('#myTable').on('click', '.delete-recipe', function() {
                let id = $(this).data('id');
                let name = $('.id-product-' + id).text();
                let url = '{{route("recipe.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: id,
                };
                swalQuestion('<span class="fs-16">Bạn có muốn xóa công thức của sản phẩm ' + name + ' này không</span>', function(alert) {
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
            //sua phi van chuyen 
            $('.update-fee').submit(function(e){
                e.preventDefault();
                let url = "{{route('fee.update')}}";
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let formData = new FormData($(this)[0]);
                callAjax(url, method, formData, headers,
                    function(data) {
                        if(data.res == 'warning'){
                            $('.error-fee').text(data.status.fee);
                        }else{
                            swalNotification(data.title,data.status,data.icon,
                                function(callback) {
                                    if (callback) {
                                        location.reload();
                                    }
                                }
                            );
                        }
                    },
                    function(err) {
                        console.log(err);
                    }
                ,1);
            });
            //xoa phi van chuyen
            $('#myTable').on('click', '.delete-fee', function() {
                let id = $(this).data('id');
                let url = '{{route("fee.delete")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let data = {
                    id: id,
                };
                swalQuestion('<span class="fs-16">Bạn có muốn xóa phí vận chuyển này không</span>', function(alert) {
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
            //xoa nhieu phi van chuyen
            $('.delete-all-fee').click(function() {
                let arrId = [];
                let url = '{{route("fee.deleteAll")}}';
                let method = "POST";
                let headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                let html = '<span class="fs-16">Bạn có muốn xóa những phí vận chuyển này không</span>';
                $('input[type="checkbox"]:checked').each(function(k, v) {
                    let id = parseInt($(this).val());
                    arrId.push({
                        id: id
                    });
                })
                let data = {
                    arrId,
                };
                swalQuestion(html, function(alert) {
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