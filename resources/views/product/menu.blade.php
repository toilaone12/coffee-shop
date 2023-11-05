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
            @foreach($parentCategorys as $key => $parent)
            <div class="col-md-6 mb-5 pb-3">
                <h3 class="mb-5 heading-pricing ftco-animate">{{$parent->name_category}}</h3>
                @foreach($childCategorys as $key => $child)
                    @if($child->id_parent_category == $parent->id_category)
                        @foreach($products as $keyProduct => $product)
                            @if($child->id_category == $product->id_category)
                            <div class="pricing-entry d-flex ftco-animate align-items-center choose-product" data-slug="{{$product->slug_product}}">
                                <div class="img" style="background-image: url('{{asset($product->image_product)}}');"></div>
                                <div class="desc pl-3">
                                    <div class="d-flex text">
                                        <h3><span>{{$product->name_product}}</span></h3>
                                        <span class="price">{{number_format($product->price_product,0,',','.')}} đ</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection