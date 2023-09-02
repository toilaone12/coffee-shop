<!-- resources/views/phieu_xuat_hang.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Phiếu Xuất Hàng</title>
    <!-- <link rel="stylesheet" type="text/css" href="{{ public_path('css/phieu_xuat_hang.css') }}"> -->
</head>
<style>
    /* public/css/phieu_xuat_hang.css */

/* Phần header */
body {
    font-family: Dejavu Sans;
}

.header {
    text-align: center;
    padding: 20px;
    background-color: #333;
    color: #fff;
}

.header h2 {
    font-size: 24px;
    margin: 0;
}

/* Bảng danh sách hàng hóa */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

/* Phần footer */
.footer {
    text-align: right;
    padding: 10px;
    background-color: #eee;
}

.header p {
    font-size: 22px;
    margin: 5px 0;
    font-weight: bold;
    color: #333;
    text-align: center;
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
    <header>
        <h2>Chi tiết hàng hóa</h2>
        <p>Tên Nhà Cung Cấp: {{$supplier->name_supplier}}</p>
        <p>Người Xuất: {{$fullname}}</p>
        <p>Ngày Nhập: {{ date('d/m/Y H:i',strtotime($note->updated_at)) }}</p>
        <p>Ngày Xuất: {{ date('d/m/Y H:i') }}</p>
    </header>
    <main>
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
                    <td>{{$one->quantity_ingredient}}</td>
                    <td>{{number_format($one->price_ingredient,0,',','.')}} đ</td>
                    <td>{{number_format(($total),0,',','.')}} đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="footer">
            <p>Tổng cộng: {{number_format($allTotal,0,',','.')}} ₫</p>
        </div>
    </main>
    <footer>
        <p>Ngày: {{ date('d/m/Y H:i') }}</p>
    </footer>
</body>

</html>