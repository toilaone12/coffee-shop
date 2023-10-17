@extends('page')
@section('content')
<section class="home-slider owl-carousel">

  <div class="slider-item" style="background-image: url();" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center">

        <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">Giỏ hàng</h1>
          <p class="breadcrumbs"><span class="mr-2"><a href="{{route('page.home')}}">Trang chủ</a></span> <span>Giỏ hàng</span></p>
        </div>

      </div>
    </div>
  </div>
</section>

<section class="ftco-section ftco-cart">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <div class="cart-list">
          <table class="table">
            <thead class="thead-primary">
              <tr class="text-center fs-15">
                <th>&nbsp;</th>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng cộng</th>
                <th>Ghi chú</th>
              </tr>
            </thead>
            <tbody>
              @php
              $total = 0;
              @endphp
              @if($cart)
              @foreach($cart as $key => $one)
              @php
              $total += $one['price_product'];
              @endphp
              <tr class="text-center">
                <td class="product-remove">
                  <a href="{{route('cart.delete',['id' => $key])}}"><span class="icon-close"></span></a>
                </td>

                <td class="image-prod">
                  <img src="{{asset($one['image_product'])}}" class="img object-fit-cover" alt="">
                </td>

                <td class="product-name">
                  <h3>{{$one['name_product']}}</h3>
                </td>

                <td class="price">{{number_format($one['price_product'] / $one['quantity_product'],0,',','.')}} đ</td>

                <td class="quantity">
                  <div class="input-group mb-3">
                    <input type="text" name="quantity" class="quantity form-control input-number" value="{{$one['quantity_product']}}" min="1" max="100">
                  </div>
                </td>

                <td class="total">{{number_format($one['price_product'],0,',','.')}} đ</td>
                <td class="note text-white">{{$one['note_product'] ? $one['note_product'] : 'Không có'}}</td>
              </tr>
              @endforeach
              @else
              @foreach($list as $key => $one)
              @php
              $total += $one['price_product'];
              @endphp
              <tr class="text-center">
                <td class="product-remove">
                  <a href="{{route('cart.delete',['id' => $one['id_product']])}}">
                    <span class="icon-close"></span>
                  </a>
                </td>

                <td class="image-prod">
                  <img src="{{asset($one['image_product'])}}" class="img object-fit-cover" alt="">
                </td>

                <td class="product-name">
                  <h3>{{$one['name_product']}}</h3>
                </td>

                <td class="price">{{number_format($one['price_product'] / $one['quantity_product'],0,',','.')}} đ</td>

                <td class="quantity">
                  <div class="input-group mb-3">
                    <input type="text" name="quantity" class="quantity form-control input-number" value="{{$one['quantity_product']}}" min="1" max="100">
                  </div>
                </td>

                <td class="total">{{number_format($one['price_product'],0,',','.')}} đ</td>
                <td class="note text-white">{{$one['note_product'] ? $one['note_product'] : 'Không có'}}</td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row justify-content-between">
      <div class="col col-lg-5 col-md-6 mt-5 cart-wrap ftco-animate">
        <form class="customer-apply">
          <div class="cart-total mb-3">
            <h3>Thông tin khách hàng</h3>
            <div class="form-group">
              <label for="fullname">Họ và tên</label>
              <input type="text" name="fullname" value="{{$customer ? $customer->name_customer : ''}}" class="form-control fullname-order">
              <span class="text-danger error-fullname-order"></span>
            </div>
            <div class="form-group">
              <label for="phone">Số điện thoại</label>
              <input type="phone" name="phone" max="10" value="{{$customer ? $customer->phone_customer : ''}}" class="form-control phone-order">
              <span class="text-danger error-phone-order"></span>
            </div>
            <div class="form-group">
              <label for="address">Địa chỉ</label>
              <input type="text" name="address" value="{{$customer ? $customer->address_customer : ''}}" class="form-control address-order">
              <span class="text-danger error-address-order"></span>
            </div>
          </div>
          <p class="text-center">
            <button type="submit" class="btn btn-secondary w-100 py-3 px-4" >
              Xác nhận
            </button>
          </p>
        </form>
      </div>
      <div class="col col-lg-5 col-md-6 mt-5 cart-wrap ftco-animate">
        <div class="cart-total mb-3">
          <h3>Tổng tiền giỏ hàng</h3>
          <p class="d-flex align-items-center">
            <span class="fs-15">Tổng giá trị</span>
            <span class="total-product">{{number_format($total,0,',','.')}} đ</span>
          </p>
          <p class="d-flex align-items-center">
            <span class="fs-15">Phí vận chuyển</span>
            <span class="d-flex align-items-center cursor-pointer">
              <span class="fee-ship">0 đ</span>
              <span 
              class="ml-sm-2 ml-lg-3 w-50 btn btn-primary btn-outline-primary fs-13 modal-fee" 
              data-toggle="modal" data-target="#feeModal"
              >
                Tra giá
              </span>
            </span>
          </p>
          <p class="d-flex align-items-center">
            <span class="fs-15">Khuyến mãi</span>
            <span class="d-flex align-items-center cursor-pointer">
              <span class="fee-discount">0 đ</span>
              <span 
              class="ml-2 ml-sm-2 ml-lg-3 w-50 btn btn-primary btn-outline-primary fs-13 choose-discount"
              data-toggle="modal" data-target="#couponModal"
              >
                Áp dụng
              </span>
            </span>

            <hr>
          <p class="d-flex total-price align-items-center">
            <span class="fs-15">Tổng tiền</span>
            <span class="total-cart text-lowercase">{{number_format($total,0,',','.')}} đ</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center mb-5 pb-3">
      <div class="col-md-7 heading-section ftco-animate text-center">
        <h2 class="mb-4">Sản phẩm liên quan</h2>
      </div>
    </div>
    <div class="row">
      @foreach($relatedProduct as $key => $related)
      <div class="col-md-3">
        <div class="menu-wrap">
          <a href="#" class="menu-img img mb-4 image-{{$related->id_product}}" style="background-image: url('{{asset($related->image_product)}}');" data-image="{{asset($related->image_product)}}">
          </a>
          <div class="text">
            <h3 class="text-center"><a href="#" class="name-{{$related->id_product}}">{{$related->name_product}}</a></h3>
            <p class="text-center price price-{{$related->id_product}}"><span>{{number_format($related->price_product,0,',','.')}} đ</span></p>
            <p>
              <button type="button" class="btn btn-primary btn-outline-primary open-modal-{{$related->id_product}} product m-auto d-block" data-toggle="modal" data-target="#exampleModal" data-id="{{$related->id_product}}">
                Đặt hàng
              </button>
            </p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@include('home.modal')
@include('fee.modal')
@include('coupon.modal')
@endsection