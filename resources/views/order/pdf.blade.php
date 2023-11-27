<!-- resources/views/phieu_xuat_hang.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Hóa đơn</title>
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
.invoice {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.header,
.details,
.items,
.total {
  margin-bottom: 20px;
}

.items {
    border-bottom: 1px solid #ccc;
}

.items .item {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
}

.item-name {
  flex: 2;
  margin-right: 200px;
}

.quantity,
.price {
  flex: 1;
  text-align: right;
}
.quantity{
    margin-right: 120px
}
.price{
    margin-right: 50px
}
</style>
<body>
    <header>
        <h1>Hóa đơn</h1>
    </header>
    <main>
        <div class="info">
            <div class="">
                <p>Ngày nhập: {{ date('d/m/Y H:i') }}</p>
            </div>
            <div class="">
                <p>Mã đơn: {{$order->code_order}}</p>
                <p>Người mua: {{$order->name_order}}</p>
                <p>Địa chỉ nhận hàng: {{$order->address_order}}</p>
            </div>
        </div>
        <div class="invoice">
            <div class="header">
                <span class="item-name">Mặt hàng</span>
                <span style="margin-right: 85px;">Số lượng</span>
                <span class="price">Đơn giá</span>
                <span class="total">Thành tiền</span>
            </div>
            <div class="items">
                @php
                    $allTotal = 0;
                @endphp
                @foreach($details as $key => $one)
                @php
                    $allTotal += intval($one->price_product);
                @endphp
                <div class="item">
                    <span class="item-name">{{$one->name_product}}</span>
                    <span class="quantity">x{{$one->quantity_product}}</span>
                    <span class="price">{{number_format(($one->price_product / $one->quantity_product),0,',','.')}} đ</span>
                    <span class="total">{{number_format(($one->price_product),0,',','.')}} đ</span>
                </div>
                @endforeach
            </div>
            <div class="total">
                <p>Tổng tiền phải thanh toán: {{number_format($allTotal,0,',','.')}} ₫</p>
            </div>
            <div class="discount">
                <p>Tổng tiền đã giảm: {{number_format($allTotal,0,',','.')}} ₫</p>
            </div>
        </div>
    </main>
</body>

</html>