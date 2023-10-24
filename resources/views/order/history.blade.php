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
              <li class="list-group-item">
                <h5>Đơn hàng #1</h5>
                <p>Ngày đặt hàng: 2023-01-15</p>
                <p>Trạng thái: Đã giao hàng</p>
                <p>Tổng tiền: $100.00</p>
                <a href="#">Chi tiết đơn hàng</a>
              </li>
              <li class="list-group-item">
                <h5>Đơn hàng #2</h5>
                <p>Ngày đặt hàng: 2023-02-20</p>
                <p>Trạng thái: Đang xử lý</p>
                <p>Tổng tiền: $75.00</p>
                <a href="#">Chi tiết đơn hàng</a>
              </li>
              <!-- Thêm các mục đơn hàng khác tương tự ở đây -->
            </ul>
          </div>
        </div>
      </div> <!-- .col-md-8 -->
    </div>
  </div>
</section> <!-- .section -->
@endsection