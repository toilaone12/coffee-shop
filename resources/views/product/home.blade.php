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
            <div class="col-lg-5 mb-5 ftco-animate">
                <div class="owl-carousel owl-theme main-carousel">
                    <a href="{{ asset($product->image_product) }}" class="image-popup">
                        <img src="{{ asset($product->image_product) }}" width="445" height="334" class="object-fit-cover image-detail-product" alt="Product Image">
                    </a>
                    @foreach($gallerys as $one)
                    <a href="{{ asset($one->image_gallery) }}" class="image-popup rounded">
                        <img src="{{ asset($one->image_gallery) }}" width="445" height="334" class="object-fit-cover" alt="Product Image">
                    </a>
                    @endforeach
                </div>
                <div class="owl-carousel owl-theme thumbs-carousel mt-2">
                    <div class="rounded px-2 py-2 border-secondary border">
                        <img src="{{ asset($product->image_product) }}" width="65" height="50" alt="Thumbnail Image">
                    </div>
                    @foreach($gallerys as $one)
                        <div class="rounded px-2 py-2 border-secondary border">
                            <img src="{{ asset($one->image_gallery) }}" width="65" height="50" alt="Thumbnail Image">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-7 product-details pl-md-5 ftco-animate">
                <h3 class="name-detail-product">{{$product->name_product}}</h3>
                <p class="price"><span class="price-detail-product">{{number_format($product->price_product,0,',','.')}} đ</span></p>
                {!!$product->description_product!!}
                <div class="row mt-4">
                    <div class="w-100"></div>
                    <div class="input-group col-md-6 d-flex mb-3">
                        <span class="input-group-btn mr-2">
                            <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                                <i class="icon-minus"></i>
                            </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control input-number quantity-detail-product" value="1" min="1" max="99">
                        <span class="input-group-btn ml-2">
                            <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                <i class="icon-plus"></i>
                            </button>
                        </span>
                    </div>
                    <div class="w-100"></div>
                    <div class="input-group col-md-6 d-flex mb-3">
                        <textarea name="review" id="" cols="30" rows="10" class="form-note text-left fs-15 note-detail-product" placeholder="Ghi chú"></textarea>
                    </div>
                </div>
                <div class="d-flex mt-5">
                    <p><button type="submit" id="add-product-cart" data-id="{{$product->id_product}}" class="btn btn-primary py-3 px-5 fs-13 mr-5">Thêm vào giỏ hàng</button></p>
                    <p><button type="submit" id="add-detail-cart" class="btn btn-primary py-3 px-5 fs-13">Đặt hàng</button></p>
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
            @foreach($relates as $related)
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
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section ftco-animate text-center">
                <h2 class="mb-4">Đánh giá sản phẩm</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-ssm-12 ftco-animate">
                <form class="review-product">
                    <div class="form-group">
                        <input type="text" name="fullname" class="form-control fs-16" placeholder="Họ & tên">
                        <input type="hidden" name="id" value="{{$product->id_product}}">
                        <div class="fs-13 text-danger error-fullname-review"></div>
                    </div>
                    <div class="d-flex">
                        @for($i = 1; $i <= 5; $i++) <li style="list-style:none">
                            <span class="icon-star text-secondary mr-2 cursor-pointer fs-20 choose-star" data-rating="{{$i}}">
                            </span>
                            </li>
                            @endfor
                    </div>
                    <div class="fs-13 text-danger error-star-review"></div>
                    <div class="form-group mt-2">
                        <textarea name="review" id="" cols="30" rows="7" class="form-control fs-16" placeholder="Nội dung đánh giá"></textarea>
                        <div class="fs-13 text-danger error-review"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary py-3 px-5">Gửi yêu cầu</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-7 col-ssm-12 mt-ssm-5 ftco-animate ml-lg-5 ml-ssm-0">
                @foreach($reviews as $key => $review)
                @if($review->id_reply == 0)
                <div class="d-flex flex-start mb-3">
                    <!-- <img class="rounded-circle shadow-1-strong mr-2" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(10).webp" alt="avatar" width="30" height="30" /> -->
                    <div class="rounded-circle fs-16 bg-primary text-center mr-2 text-white font-weight-bold" style="width:30px; height:30px;">
                        {{substr($review->name_review,0,1)}}
                    </div>
                    <div class="flex-grow-1 flex-shrink-1">
                        <div>
                            <div class="d-flex align-items-center">
                                <span class="fs-16 text-white">
                                    {{$review->name_review}}
                                </span>
                                <div class="mx-2 text-white">-</div>
                                <span class="fs-16 text-white">{{date('d-m-Y',strtotime($review->created_at))}}</span>
                            </div>
                            <span class="d-flex mb-2">
                                @for($i = 1; $i <= intval($review->rating_review); $i++) <li style="list-style:none">
                                    <span class="icon-star text-warning cursor-pointer mr-1 fs-16">
                                    </span>
                                </li>
                                @endfor
                                @for($i = intval($review->rating_review); $i < 5; $i++) <li style="list-style:none">
                                    <span class="icon-star text-secondary cursor-pointer mr-1 fs-16">
                                    </span>
                                </li>
                                @endfor
                            </span>
                            <div class="card">
                                <span class="fs-16 text-dark px-3 py-2">
                                    {{$review->content_review}}
                                </span>
                            </div>
                        </div>
                        <!-- lay cau tra loi cua qtv -->
                        @foreach($reviews as $key => $reply)
                        @if($reply->id_reply == $review->id_review)
                        <div class="d-flex flex-start mt-4">
                            <div class="rounded-circle fs-16 bg-primary text-center mr-2 text-white font-weight-bold" style="width:30px; height:30px;">
                                {{substr($reply->name_review,0,1)}}
                            </div>
                            <div class="flex-grow-1 flex-shrink-1">
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="fs-16 text-white">
                                            {{$reply->name_review}}
                                        </span>
                                        <div class="rounded bg-danger text-white fs-13 px-1 py-1 ml-2">QTV</div>
                                        <div class="mx-2 text-white">-</div>
                                        <span class="fs-16 text-white">{{date('d-m-Y',strtotime($reply->created_at))}}</span>
                                    </div>
                                    <div class="card">
                                        <span class="fs-16 text-dark px-3 py-2">
                                            {{$reply->content_review}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@include('home.modal')
@endsection