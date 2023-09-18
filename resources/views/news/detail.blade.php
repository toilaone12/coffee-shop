@extends('page')
@section('content')
<section class="home-slider owl-carousel">

  <div class="slider-item" style="background-image:url('{{asset($one->image_new)}}');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center">

        <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">Chi tiết Blog</h1>
          <p class="breadcrumbs"><span class="mr-2"><a href="{{route('page.home')}}">Trang chủ</a></span> <span class="mr-2"><a href="blog.html">Blog</a></span> <span>Chi tiết bài viết</span></p>
        </div>

      </div>
    </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    {!!$one->content_new!!}
  </div>
</section> 
@endsection