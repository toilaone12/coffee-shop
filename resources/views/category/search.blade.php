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
      <div class="col-xl-4 sidebar ftco-animate">
        <div class="sidebar-box">
          <form action="{{route('category.search')}}" method="POST" class="search-form">
            @csrf
            <div class="form-group">
              <div class="icon">
                <span class="icon-search"></span>
              </div>
              <input type="text" name="keyword" class="form-control" placeholder="Search...">
              @error('keyword')
              <div class="text-danger">{{$message}}</div>
              @enderror
            </div>
          </form>
        </div>
        <div class="sidebar-box ftco-animate">
          <div class="categories">
            <h3>Danh mục sản phẩm</h3>
            @foreach($listChilds as $key => $child)
            <li><a href="{{route('category.home',['parent' => $child['slug_parent'], 'child' => $child['slug_child']])}}" class="fs-15">{{$child['name_category']}} <span>({{$child['number_product']}})</span></a></li>
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="row d-flex pt-4 ml-lg-3">
          @foreach($lists as $key => $one)
          <div class="col-md-4 text-center">
            <div class="menu-wrap">
              <a href="#" class="menu-img img mb-4 image-{{$one->id_product}}" style="background-image: url('{{asset($one->image_product)}}'); height: 215px !important;" data-image="{{asset($one->image_product)}}">
              </a>
              <div class="text">
                <h3><a href="#" class="name-{{$one->id_product}}">{{$one->name_product}}</a></h3>
                <p class="price price-{{$one->id_product}}"><span>{{number_format($one->price_product,0,',','.')}} đ</span></p>
                <p>
                  <button type="button" class="btn btn-primary btn-outline-primary open-modal-{{$one->id_product}} product" data-toggle="modal" data-target="#exampleModal" data-id="{{$one->id_product}}">
                    Đặt hàng
                  </button>
                </p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@include('home.modal')
@endsection