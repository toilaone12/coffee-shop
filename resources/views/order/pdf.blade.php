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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="{{asset('./back-end/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <div class="card">
        <div class="card-body">

            <div class="container">
                <div class="row">
                    <div class="col-xl-12 fs-30">
                        Harper 7 Coffee
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-6">
                        <ul class="list-unstyled float-start">
                            <li style="font-size: 25px;">Khách hàng</li>
                            <li>Người nhận: {{$order->name_order}}</li>
                            <li>Số điện thoại: {{$order->phone_order}}</li>
                            <li>Địa chỉ: {{$order->address_order}}</li>
                        </ul>
                    </div>
                    <div class="col-xl-6">
                        <ul class="list-unstyled float-end">
                            <li style="font-size: 25px; color: red;">Cửa hàng</li>
                            <li>Tô Hiệu, Hà Đông, Hà Nội</li>
                            <li>0338441123</li>
                            <li>harper7coffee@gmail.com</li>
                        </ul>
                    </div>
                </div>

                <div class="row text-center">
                    <h3 class="text-uppercase text-center mt-3" style="font-size: 20p;">Hóa đơn #{{$order->code_order}}</h3>
                </div>

                <div class="row mx-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên mặt hàng</th>
                                <th scope="col" class="text-center">Số lượng</th>
                                <th scope="col" class="text-center">Đơn giá</th>
                                <th scope="col" class="text-center">Giá thành</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $allTotal = 0; @endphp
                            @foreach($details as $one)
                            @php $allTotal += $one->price_product; @endphp
                            <tr>
                                <td>{{$one->name_product}}</td>
                                <td class="text-center">x{{$one->quantity_product}}</td>
                                <td class="text-center">{{number_format($one->price_product / $one->quantity_product,0,',','.')}} đ</td>
                                <td class="text-center">{{number_format($one->price_product,0,',','.')}} đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <ul class="list-unstyled float-start ms-4">
                            <li><span class="me-2 float-start">Tổng tiền:</span>{{number_format($allTotal + $order->fee_discount - $order->fee_ship,0,',','.')}} đ</li>
                            <li> <span class="me-2">Tổng tiền được giảm:</span>{{number_format($order->fee_discount,0,',','.')}} đ</li>
                            <li><span class="float-start me-2">Phí vận chuyển: </span>{{number_format($order->fee_ship,0,',','.')}} đ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="" style="margin-top: 300px">
        <button class="btn btn-primary print-invoice m-auto d-block w-50">In hóa đơn</button>
    </div>
</body>
<!-- Firebase -->
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
<script>
    $(document).ready(function(){
        //in hoa don
        $('.print-invoice').on('click',function(){
            window.print();
        })
    })
</script>
</html>