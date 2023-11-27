@extends('page')
@section('content')
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
<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-xl-12 ftco-animate">
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <ul class="list-group">
              @foreach($orders as $key => $order)
              <li class="list-group-item mb-2 rounded">
                <div class="d-flex align-items-center justify-content-between">
                  <span class="text-secondary fs-20">Đơn hàng #{{$order->code_order}}</span>
                  <span class="fs-16 text-secondary">
                    Tình trạng đơn hàng: 
                    <span class="{{$order->status_order == 0 ? 'text-warning' : ($order->status_order == 1 || $order->status_order == 2 || $order->status_order == 3 ? 'text-success' : 'text-danger')}}">
                      {{$order->status_order == 0 ? 'Đang chờ nhận đơn' : ($order->status_order == 1 ? 'Đã nhận đơn' : ($order->status_order == 2 ? 'Đang giao hàng' : ($order->status_order == 3 ? 'Giao hàng thành công' : 'Đã hủy đơn')))}}
                    </span>
                  </span>
                </div>
                <div class="mt-3 d-flex align-items-center justify-content-between">
                  <span class="text-secondary fs-16">Tổng tiền: {{number_format($order->total_order,0,',','.')}} đ</span>
                  <a href="{{route('order.detail',['code' => $order->code_order])}}" class="fs-16 btn btn-primary">Xem chi tiết</a>
                </div>
              </li>
              @endforeach
              <!-- Thêm các mục đơn hàng khác tương tự ở đây -->
            </ul>
          </div>
        </div>
      </div> <!-- .col-md-8 -->
    </div>
  </div>
</section> <!-- .section -->
@endsection