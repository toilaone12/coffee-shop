@extends('page')
@section('content')
<section class="home-slider owl-carousel">
  <div class="slider-item" style="background-image: url();" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center">
        <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">Tin tức</h1>
          <p class="breadcrumbs"><span class="mr-2 fs-13"><a href="{{route('page.home')}}">Trang chủ</a></span> <span>Tin tức</span></p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="ftco-section">
  <div class="container">
    <div class="row d-flex">
      @foreach($lists as $key => $one)
      <div class="col-md-4 d-flex ftco-animate">
        <div class="blog-entry align-self-stretch">
            <a href="{{route('blog.detail',['slug' => $one->slug_new])}}" class="block-20" style="background-image: url('{{asset($one->image_new)}}');">
            </a>
            <div class="text py-4 d-block">
              <div class="meta">
                <div><a href="{{route('blog.detail',['slug' => $one->slug_new])}}">{{date('d/m/Y',strtotime($one->updated_at))}}</a></div>
                <span> - </span>
                <div><a href="{{route('blog.detail',['slug' => $one->slug_new])}}">Quản trị viên</a></div>
              </div>
              <h3 class="heading mt-2"><a href="{{route('blog.detail',['slug' => $one->slug_new])}}">{{$one->title_new}}</a></h3>
              <p>{{$one->subtitle_new}}</p>
            </div>
        </div>
      </div>
      @endforeach
    </div>
    {!!$lists->links('pagination.paginate')!!}
  </div>
</section>
@include('home.modal')
@endsection