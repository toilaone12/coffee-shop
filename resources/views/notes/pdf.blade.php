<!-- resources/views/phieu_xuat_hang.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Phiếu Xuất Hàng</title>
    <!-- <link rel="stylesheet" type="text/css" href="{{ public_path('css/phieu_xuat_hang.css') }}"> -->
</head>
<style>
body {
    font-family: DejaVu Sans;
}

/* Header */
header {
    text-align: center;
    margin-bottom: 20px;
}

/* Tiêu đề của phiếu nhập kho */
h1 {
    font-size: 24px;
    margin: 0;
}

/* Phần thông tin */
.info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.info-left,
.info-right {
    width: 48%;
}

/* Bảng chi tiết sản phẩm */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    border: 1px solid #000;
    padding: 10px;
    text-align: center;
}

/* Phần footer */
footer {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.footer-left,
.footer-right {
    width: 48%;
}

/* Định dạng số tiền và ngày tháng */
p {
    margin: 0;
}

/* Định dạng ngày tháng */
.date {
    font-weight: bold;
}

/* Tùy chỉnh CSS cho phần tổng cộng */
.footer p {
    font-size: 18px;
    margin: 10px 0;
    font-weight: bold;
    color: #333;
}
</style>
<body>
    <!-- <header>
        <h2>Chi tiết hàng hóa</h2>
        <p>Tên Nhà Cung Cấp: {{$supplier->name_supplier}}</p>
        <p>Người Xuất: {{$fullname}}</p>
        <p>Ngày Nhập: {{ date('d/m/Y H:i',strtotime($note->updated_at)) }}</p>
        <p>Ngày Xuất: {{ date('d/m/Y H:i') }}</p>
    </header> -->
    <!-- <main>
        <div class="header">
            <h2>Chi tiết hàng hóa</h2>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã phiếu</th>
                    <th>Tên nguyên liệu</th>
                    <th>Đơn vị tính</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $allTotal = 0;
                @endphp
                @foreach($list as $key => $one)
                @php
                    $total = $one->price_ingredient * $one->quantity_ingredient;
                    $allTotal += $total;
                @endphp
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$one->code_note}}</td>
                    <td>{{$one->name_ingredient}}</td>
                    <td>{{$one->fullname_unit}}</td>
                    <td width="20">{{$one->quantity_ingredient}}</td>
                    <td>{{number_format($one->price_ingredient,0,',','.')}} đ</td>
                    <td>{{number_format(($total),0,',','.')}} đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total">
            <p>Tổng cộng: {{number_format($allTotal,0,',','.')}} ₫</p>
        </div>
    </main> -->
    <!-- <footer>
        <p>Hà Nội, ngày {{ date('d') }} tháng {{ date('m') }} năm {{ date('Y') }}</p>
        <div class="footer">
            <div class="footer-left">
                <h4>Người lập phiếu</h4>
                <p style="margin-top:100px">{{$fullname}}</p>
            </div>
            <div class="footer-right">
                <h4>Người giao hàng</h4>
                <p style="margin-top:100px">{{$supplier->name_supplier}}</p>
            </div>
        </div>
    </footer> -->
    <header>
        <h1>PHIẾU NHẬP KHO</h1>
    </header>
    <main>
        <div class="info">
            <div class="info-left">
                <p>Ngày Nhập: {{ date('d/m/Y H:i',strtotime($note->updated_at)) }}</p>
                <p>Nhà Cung Cấp: {{$supplier->name_supplier}}</p>
            </div>
            <div class="info-right">
                <p>Mã Phiếu: {{$note->code_note}}</p>
                <p>Người Nhập: {{$fullname}}</p>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên nguyên liệu</th>
                    <th>Đơn vị tính</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $allTotal = 0;
                @endphp
                @foreach($list as $key => $one)
                @php
                    $total = $one->price_ingredient * $one->quantity_ingredient;
                    $allTotal += $total;
                @endphp
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$one->name_ingredient}}</td>
                    <td width="50">{{$one->fullname_unit}}</td>
                    <td width="20">{{$one->quantity_ingredient}}</td>
                    <td>{{number_format($one->price_ingredient,0,',','.')}} đ</td>
                    <td>{{number_format(($total),0,',','.')}} đ</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="6" style="padding: 8px 10px">Tổng cộng: {{number_format($allTotal,0,',','.')}} ₫</td>
                </tr>
            </tbody>
        </table>
    </main>
    <footer>
        <table style="width: 100%;">
            <tr>
                <td colspan="2">Hà Nội, ngày {{ date('d') }} tháng {{ date('m') }} năm {{ date('Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: left; width: 50%; margin-top: 20px; margin-left: 20px;">
                    <p style="margin-left: 20px;">Người lập phiếu</p>
                    <p style="margin-top: 100px; margin-left: 10px;">{{$fullname}}</p>
                </td>
                <td style="text-align: right; width: 50%;">
                    <p style="margin-right: 20px;">Người giao hàng</p>
                    <p style="margin-top: 100px; margin-right: 60px">{{$supplier->name_supplier}}</p>
                </td>
            </tr>
        </table>
    </footer>
</body>

</html>