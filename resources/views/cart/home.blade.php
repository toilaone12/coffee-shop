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
              <tr class="text-center">
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
              @foreach($list as $key => $one)
              <tr class="text-center">
                <td class="product-remove"><a href="#"><span class="icon-close"></span></a></td>

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
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row justify-content-end">
      <div class="col col-lg-3 col-md-6 mt-5 cart-wrap ftco-animate">
        <div class="cart-total mb-3">
          <h3>Cart Totals</h3>
          <p class="d-flex">
            <span>Subtotal</span>
            <span>$20.60</span>
          </p>
          <p class="d-flex">
            <span>Delivery</span>
            <span>$0.00</span>
          </p>
          <p class="d-flex">
            <span>Discount</span>
            <span>$3.00</span>
          </p>
          <hr>
          <p class="d-flex total-price">
            <span>Total</span>
            <span>$17.60</span>
          </p>
        </div>
        <p class="text-center"><a href="checkout.html" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
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
          <a 
              href="#" 
              class="menu-img img mb-4 image-{{$related->id_product}}" 
              style="background-image: url('{{asset($related->image_product)}}');"
              data-image="{{asset($related->image_product)}}"
          >
          </a>
          <div class="text">
              <h3 class="text-center"><a href="#" class="name-{{$related->id_product}}">{{$related->name_product}}</a></h3>
              <p class="text-center price price-{{$related->id_product}}"><span>{{number_format($related->price_product,0,',','.')}} đ</span></p>
              <p>
                  <button 
                      type="button" 
                      class="btn btn-primary btn-outline-primary open-modal-{{$related->id_product}} product m-auto d-block" 
                      data-toggle="modal" 
                      data-target="#exampleModal"
                      data-id="{{$related->id_product}}"
                  >
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
@include('home.modal');
@endsection