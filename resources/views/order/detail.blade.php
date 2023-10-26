@extends('page')
@section('content')
@if($status == 0)
<style>
  #progressbar-2 li:nth-child(1):after {
    left: 1%;
    width: 100%;
    background: #c5cae9 !important;
    /* Màu mặc định */
  }
</style>
@elseif($status == 1)
<style>
  #progressbar-2 li:nth-child(2):after {
    left: 1%;
    width: 100%;
    background: #c5cae9 !important;
    /* Màu mặc định */
  }
</style>
@elseif($status == 2)
<style>
  #progressbar-2 li:nth-child(3):after {
    left: 1%;
    width: 100%;
    background: #c5cae9 !important;
    /* Màu mặc định */
  }
</style>
@else
<style>
  #progressbar-2 li:nth-child(1):after,
  #progressbar-2 li:nth-child(2):after,
  #progressbar-2 li:nth-child(3):after,
  #progressbar-2 li:nth-child(4):after {
    left: 1%;
    width: 100%;
  }
</style>
@endif
<section class="home-slider owl-carousel">
  <div class="slider-item" style="background-image: url();" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center">
        <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">{{$title}}</h1>
          <p class="breadcrumbs"><span class="mr-2"><a href="{{route('page.home')}}">Trang chủ</a></span> <span>{{$title}}</span></p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="vh-100 ftco-section">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12">
        <div class="card card-stepper text-black" style="border-radius: 16px;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="mb-0 text-dark fs-20">Đơn hàng <span class="text-primary font-weight-bold fs-20">#{{$order->code_order}}</span></span>
            </div>
            <ul id="progressbar-2" class="d-flex justify-content-between mx-0 mt-0 pt-0 pb-lg-2 pb-md-2 pb-ssm-0">
              @if($status != 4)
              <li class="active text-center" id="step1"></li>
              <li class="step0 {{$status >= 1 ? 'active' : ''}} text-center" id="step2"></li>
              <li class="step0 {{$status >= 2 ? 'active' : ''}} text-center" id="step3"></li>
              <li class="step0 {{$status >= 3 ? 'active' : ''}} text-muted text-end" id="step4"></li>
              @else
              <li class="cancel text-center w-100" id="step1"></li>
              <li class="step0 d-none text-center" id="step2"></li>
              <li class="step0 d-none text-center" id="step3"></li>
              <li class="step0 cancel text-danger text-muted text-end" id="step5"></li>
              @endif
            </ul>
            @if($status == 4)
            <div class="d-flex justify-content-between">
              <div class="d-lg-flex">
                <div>
                  <p class="fs-bold status-order">Đơn hàng</p>
                </div>
              </div>
              <div class="d-lg-flex">
                <div>
                  <p class="fs-bold" style="padding-left: 23px"></p>
                </div>
              </div>
              <div class="d-lg-flex">
                <div>
                  <p class="fs-bold mb-0"></p>
                </div>
              </div>
              <div class="d-lg-flex">
                <div>
                  <p class="fs-bold mb-0 mr-lg-3 mr-ssm-0 status-cancel">Đã hủy đơn</p>
                </div>
              </div>
            </div>
            @else
            <div class="d-flex justify-content-between">
              <div class="d-lg-flex">
                <div>
                  <p class="fs-bold status-wait">Đặt đơn</p>
                </div>
              </div>
              <div class="d-lg-flex">
                <div>
                  <p class="fs-bold status-accept">Nhận đơn</p>
                </div>
              </div>
              <div class="d-lg-flex">
                <div>
                  <p class="fs-bold mb-0 status-journey">Giao hàng</p>
                </div>
              </div>
              <div class="d-lg-flex">
                <div>
                  <p class="fs-bold mb-0 status-success">Thành công</p>
                </div>
              </div>
            </div>
            @endif
          </div>

        </div>
      </div>
      <div class="col-lg-8 mt-5">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-7 col-ssm-12">
                <p class="text-dark fs-20">Địa chỉ giao hàng</p>
                <div class="order-info">
                  <div class="d-block text-dark fs-16">Họ & tên người nhận: {{$order->name_order}}</div>
                  <div class="d-block text-secondary fs-13">Số điện thoại: {{$order->phone_order}}</div>
                  <div class="d-block text-secondary fs-13">Địa chỉ: {{$order->address_order}}</div>
                </div>
              </div>
              <div class="col-lg-3 col-ssm-12">
                <p class="text-dark fs-20 mt-ssm-3">Chức năng</p>
                <div class="d-flex">
                  <a href="{{route('order.change',['id' => $order->id_order,'status' => 4])}}" class="btn btn-primary rounded {{$status >= 2 && $status <= 4 ? 'disabled' : ''}}">Hủy đơn hàng</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4"></div>
      <div class="col-md-12 ftco-animate mt-5">
        <div class="cart-list">
          <table class="table">
            <thead class="thead-primary">
              <tr class="text-center">
                <th>&nbsp;</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng tiền sản phẩm</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orderDetail as $key => $one)
              <tr class="text-center">
                <td class="image-prod">
                  <div class="img" style="background-image:url('{{asset($one->image_product)}}');"></div>
                </td>
                <td class="product-name">
                  <h3>{{$one->name_product}}</h3>
                </td>
                <td class="price">{{number_format($one->price_product / $one->quantity_product,0,',','.')}} đ</td>
                <td class="price">x {{$one->quantity_product}}</td>
                <td class="total">{{number_format($one->price_product,0,',','.')}} đ</td>
              </tr><!-- END TR-->
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection