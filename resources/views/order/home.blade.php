@extends('page')
@section('content')
<section class="home-slider owl-carousel">
  <div class="slider-item" style="background-image: url();" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center">
        <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">Đơn hàng</h1>
          <p class="breadcrumbs"><span class="mr-2"><a href="{{route('page.home')}}">Trang chủ</a></span> <span>Giỏ hàng</span></p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-xl-8 ftco-animate">
        <form action="#" class="billing-form ftco-bg-dark p-3 p-md-5">
          <h3 class="mb-4 billing-heading">Thông tin khách hàng</h3>
          <div class="row align-items-end">
            <div class="col-md-12">
              <div class="form-group">
                <label for="firstname">Họ và tên</label>
                <input type="text" class="form-control fs-12" disabled value="{{$order['fullname']}}" placeholder="">
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" class="form-control fs-12" disabled value="{{$order['phone']}}">
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" class="form-control fs-12" disabled value="{{$order['address']}}">
              </div>
            </div>
            <div class="w-100"></div>
          </div>
        </form><!-- END -->
        <div class="row mt-5 pt-3 d-flex">
          <div class="col-md-6 d-flex">
            <div class="cart-detail cart-total ftco-bg-dark p-3 p-md-4">
              <h3 class="billing-heading mb-4">Tổng tiền giỏ hàng</h3>
              <p class="d-flex align-items-center">
                <span class="fs-15">Tổng giá trị</span>
                <span class="total-product">{{number_format($subtotal,0,',','.')}} đ</span>
              </p>
              <p class="d-flex align-items-center">
                <span class="fs-15">Phí vận chuyển</span>
                <span class="cursor-pointer">
                  <span class="fee-ship w-100">+ {{number_format($order['fee_ship'],0,',','.')}} đ</span>
                </span>
              </p>
              <p class="d-flex align-items-center">
                <span class="fs-15">Khuyến mãi</span>
                <span class="cursor-pointer">
                  <span class="fee-discount w-100">- {{number_format($order['fee_discount'],0,',','.')}} đ</span>
                </span>

                <hr>
              <p class="d-flex total-price align-items-center">
                <span class="fs-15">Tổng tiền</span>
                <span class="total-cart text-lowercase">{{number_format($total,0,',','.')}} đ</span>
              </p>
            </div>
          </div>
          <div class="col-md-6">
            <form class="apply-order">
              <div class="cart-detail ftco-bg-dark p-3 p-md-4">
                <h3 class="billing-heading mb-4">Yêu cầu xác nhận</h3>
                <div class="form-group">
                  <div class="col-md-12">
                    <div class="checkbox">
                      <label class="d-block m-auto"><input type="checkbox" name="privacy" class="mr-2 fs-15"> Bạn có đồng ý với các thông tin trên không?</label>
                      <span class="text-danger error-privacy fs-13"></span>
                    </div>
                  </div>
                </div>
                <p><button type="submit" class="btn btn-primary py-3 px-4 fs-15">Đặt hàng</button></p>
              </div>
            </form>
          </div>
        </div>
      </div> <!-- .col-md-8 -->
      <div class="col-xl-4 sidebar ftco-animate">
        <div class="sidebar-box ftco-animate">
          <h3>Tin tức gần đây</h3>
          @foreach($news as $key => $new)
          <div class="block-21 mb-4 d-flex">
            <a class="blog-img mr-4" style="background-image: url('{{asset($new->image_new)}}');"></a>
            <div class="text">
              <h3 class="heading"><a href="{{route('blog.detail',['slug' => $new->slug_new, 'id' => $new->id_new])}}">{{$new->title_new}}</a></h3>
              <div class="meta">
                <div>
                  <a href="{{route('blog.detail',['slug' => $new->slug_new, 'id' => $new->id_new])}}" class="fs-12"><span class="icon-calendar mr-2 fs-14"></span>{{date('d/m/Y',strtotime($new->updated_at))}}</a></div>
                <div>
                  <a href="{{route('blog.detail',['slug' => $new->slug_new, 'id' => $new->id_new])}}" class="fs-12"><span class="icon-person mr-2 fs-14"></span>Quản trị viên</a></div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section> <!-- .section -->
@include('home.modal')
@endsection