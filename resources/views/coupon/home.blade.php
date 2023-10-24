@extends('page')
@section('content')
<section class="home-slider owl-carousel">
  <div class="slider-item" style="background-image: url();" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center">
        <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">{{$title}}</h1>
          <p class="breadcrumbs"><span class="mr-2 fs-13"><a href="{{route('page.home')}}">Trang chủ</a></span> <span>{{$title}}</span></p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="ftco-section">
  <div class="container">
    <div class="row d-flex">
      <div class="col-md-12">
        <div class="row d-flex pt-4 ml-lg-3">
          @foreach($arrCoupon as $key => $one)
          <div class="col-md-6 text-center mb-ssm-3">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-secondary fs-20">Mã giảm giá</span>
              </div>
              <div class="card-body">
                <div class="fs-16 text-secondary">{{$one->name_coupon}}</div>
                <div class="d-flex align-items-center justify-content-center">
                  <img width="80" height="80" src="https://img.icons8.com/dotty/80/discount-ticket.png" alt="discount-ticket"/>
                  <span class="mx-3 fs-14 text-secondary code-coupon">{{$one->code_coupon}}</span>
                  <span class="ion-ios-copy fs-20 text-secondary cursor-pointer copy-discount"></span>
                </div>
                <h3 class="text-center fs-14 text-secondary">
                  Giảm giá {{$one->type_coupon == 1 ? number_format($one->discount_coupon,0,',','.').' đ' : $one->discount_coupon . '% giá trị sản phẩm'}} (Áp dụng cho 1 đơn hàng)
                </h3>
              </div>
              <div class="card-footer text-center">
                <p class="fs-14">Hạn sử dụng: {{date('d/m/Y',strtotime($one->expiration_time))}}</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endsection