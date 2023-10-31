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
          <div class="col-lg-3">
            <div class="d-block">
              <div class="rounded px-2 py-2 text-center bg-primary collaspe-1">
                <span class="fs-16 text-white cursor-pointer">Thông tin cá nhân</span>
              </div>
              <div class="rounded px-2 py-2 text-center bg-primary mt-3 collaspe-2">
                <span class="fs-16 text-white cursor-pointer">Đổi mật khẩu</span>
              </div>
            </div>
          </div>
          <div class="col-lg-9 mt-ssm-5 mt-sm-5 mt-md-0 mt-lg-0">
            <div class="collaspe-info">
              <div class="row">
                <div class="col-lg-4">
                  <div class="card mb-4">
                    <div class="card-body text-center">
                      <p class="fs-18 text-dark">Ảnh đại diện</p>
                      <img src="{{asset($customer->image_customer)}}" alt="avatar" class="rounded-circle" style="width: 100px; height: 100px;">
                    </div>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="card mb-4">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0 fs-15">Họ & tên</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0 change-username">{{$customer->name_customer}}</p>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0 fs-15">Email</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{$customer->email_customer}}</p>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0 fs-15">Số điện thoại</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{$customer->phone_customer}}</p>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary mt-5" data-toggle="modal" data-target="#editProfile">Sửa thông tin</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="collaspe-change d-none">
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                  <form class="change-password">
                    <input type="hidden" name="id" value={{$customer->id_customer}}>
                    <div class="form-group">
                      <label class="fs-15" for="password-customer">Mật khẩu mới</label>
                      <input type="password" name="password" id="password-customer" class="form-control" style="height: 39px !important;">
                      <button type="button" class="password-toggle-btn" style="right: 15px !important;">
                        <i class="icon-eye fs-20 text-secondary"></i>
                      </button>
                      <div class="text-danger fs-12 mt-1 error-password"></div>
                    </div>
                    <div class="form-group position-relative">
                      <label class="fs-15" for="repassword-customer">Nhập lại mật khẩu mới</label>
                      <input type="password" name="repassword" id="repassword-customer" class="form-control" style="height: 39px !important;">
                      <button type="button" class="re-password-toggle-btn" style="right: 0px !important;">
                        <i class="icon-eye fs-20 text-secondary"></i>
                      </button>
                      <div class="text-danger fs-12 mt-1 error-repassword"></div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 fs-13">Xác nhận</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@include('customer.edit')
@endsection