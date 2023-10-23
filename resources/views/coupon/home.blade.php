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
      <div class="col-md-8">
        <div class="row d-flex pt-4 ml-lg-3">
          @foreach($lists as $key => $one)
          <div class="col-md-4 text-center">
            <div class="menu-wrap"> 
              <div class="text">
                
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