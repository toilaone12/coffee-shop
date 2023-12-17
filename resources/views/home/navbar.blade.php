<?php
    use Illuminate\Support\Str;
?>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{route('page.home')}}">Harper 7<small>Coffee</small></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span>
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="{{route('page.home')}}" class="nav-link fs-14">Trang chủ</a></li>
                <li class="nav-item"><a href="{{route('news.home')}}" class="nav-link fs-14">Tin tức</a></li>
                <li class="nav-item dropdown">
                    <span class="nav-link dropdown-toggle fs-14" id="dropdown04">
                        Thực đơn
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        @foreach($parentCategorys as $parent)
                        <div class="nav-item-child">
                            <a class="nav-link fs-14 dropdown-toggle" id="dropdown05">
                                {{$parent->name_category}}
                            </a>
                            <div class="dropdown-submenu">
                                @foreach($childCategorys as $child)
                                @if($child->id_parent_category == $parent->id_category)
                                <a 
                                class="dropdown-item p-3 fs-14 text-white" 
                                href="{{route('category.home',['parent' => $parent->slug_category, 'child' => $child->slug_category])}}">
                                    {{$child->name_category}}
                                </a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item"><a href="#contact" class="nav-link fs-14">Liên hệ</a></li>
                <li class="nav-item cart dropdown">
                    <a class="nav-link" style="cursor: pointer;">
                        <span class="icon icon-shopping_cart"></span>
                        <div class="dot-cart">
                            @php
                            $cart = session('cart');
                            @endphp
                            @if(isset($cart))
                            <span class="bag d-flex justify-content-center align-items-center"><small>{{count($cart)}}</small></span>
                            @elseif(isset($carts) && count($carts) > 0)
                            <span class="bag d-flex justify-content-center align-items-center"><small>{{count($carts)}}</small></span>
                            @else
                            @endif
                        </div>
                    </a>
                    <div class="cart-hover left rounded" style="cursor: pointer;">
                        @php
                        $cart = session('cart');
                        @endphp
                        @if(isset($cart))
                        <div class="form-cart p-2 border">
                            <div class="fs-18 text-secondary mb-3">Sản phẩm mới thêm</div>
                            <div class="mb-3 overflow-auto width-cart cart-item">
                                @foreach($cart as $key => $one)
                                <div class="d-flex justify-content-start mr-3 mb-3 cart-child-{{$key}}" style="width: 22rem;">
                                    <img loading="lazy" class="object-fit-cover rounded" width="50" height="50" src="{{asset($one['image_product'])}}" alt="Card image cap">
                                    <div class="d-block" style="width: 90%">
                                        <div class="d-flex justify-content-between" style="width: 310px !important">
                                            <p class="fs-14 text-dark text-truncate mx-3">{{$one['name_product']}}</p>
                                            <p class="fs-14 text-dark price-child-{{$key}}" data-price="{{$one['price_product']}}">{{number_format($one['price_product'],0,',','.')}} đ</p>
                                        </div>
                                        <div class="d-flex w-100">
                                            <p class="fs-14 text-dark mx-3">x <span class="quantity-child-{{$key}} text-dark">{{$one['quantity_product']}}</span></p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <a href="{{route('cart.home')}}" class="btn btn-primary fs-13">Xem giỏ hàng</a>
                        </div>
                        @elseif(isset($carts) && count($carts) > 0)
                        <div class="form-cart p-2 border">
                            <div class="fs-18 text-secondary mb-3">Sản phẩm mới thêm</div>
                            <div class="mb-3 overflow-auto width-cart cart-item">
                                @foreach($carts as $key => $one)
                                <div class="d-flex justify-content-start mr-3 mb-3 cart-child-{{$one->id_product}}" style="width: 22rem;">
                                    <img loading="lazy" class="object-fit-cover rounded" width="50" height="50" src="{{asset($one['image_product'])}}" alt="Card image cap">
                                    <div class="d-block" style="width: 90%">
                                        <div class="d-flex justify-content-between" style="width: 310px !important">
                                            <p class="fs-14 text-dark text-truncate mx-3">{{$one['name_product']}}</p>
                                            <p class="fs-14 text-dark price-child-{{$one->id_product}}" data-price="{{$one['price_product']}}">{{number_format($one['price_product'],0,',','.')}} đ</p>
                                        </div>
                                        <div class="d-flex w-100">
                                            <p class="fs-14 text-dark mx-3">x <span class="quantity-child-{{$one->id_product}} text-dark">{{$one['quantity_product']}}</span></p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <a href="{{route('cart.home')}}" class="btn btn-primary fs-13">Xem giỏ hàng</a>
                        </div>
                        @endif
                    </div>
                </li>
                @php
                $id = request()->cookie('id_customer');
                @endphp
                <li class="nav-item user dropdown">
                    @if(isset($id))
                    <span class="nav-link">
                        <span class="fs-20 icon-user-circle-o text-light cursor-pointer"></span>
                    </span>
                    <div class="user-hover user-left rounded">
                        <div class="bg-black px-3 py-3 rounded cursor-pointer">
                            <div class="d-flex align-items-center border-bottom border-secondary pb-3 open-info">
                                <img src="{{asset($customer->image_customer)}}" width="36" height="36" loading="lazy" class="border border-secondary p-1 bg-light img rounded-circle">
                                <span class="ml-3 fs-15">{{$customer->name_customer}}</span>
                            </div>
                            <div class="d-flex align-items-center mt-3 open-cart">
                                <div class="rounded-circle bg-secondary p-2 d-flex align-items-center">
                                    <span class="icon-shopping_cart fs-20"></span>
                                </div>
                                <span class="ml-3 fs-15">Giỏ hàng cá nhân</span>
                            </div>
                            <div class="d-flex align-items-center mt-3 open-discount">
                                <div class="rounded-circle bg-secondary p-history d-flex align-items-center">
                                    <span class="icon-gift fs-20"></span>
                                </div>
                                <span class="ml-3 fs-15">Mã khuyến mãi</span>
                            </div>
                            <div class="d-flex align-items-center mt-3 open-history-order">
                                <div class="rounded-circle bg-secondary p-history d-flex align-items-center">
                                    <span class="icon-history fs-20"></span>
                                </div>
                                <span class="ml-3 fs-15">Lịch sử đơn hàng</span>
                            </div>
                            <div class="d-flex align-items-center mt-3 logout">
                                <div class="rounded-circle bg-secondary p-logout d-flex align-items-center">
                                    <span class="icon-sign-out fs-20"></span>
                                </div>
                                <span class="ml-3 fs-15">Đăng xuất</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <p data-toggle="modal" data-target="#userModal" class="nav-link fs-13 cursor-pointer">
                        <span class="fs-20 icon-user-circle-o text-white"></span>
                    </p>
                    @endif
                </li>
                @if(isset($id))
                <li class="nav-item noti dropdown">
                    <a class="nav-link cursor-pointer">
                        <span class="icon icon-notifications fs-22 text-light cursor-pointer"></span>
                        @if(count($isDot) > 0)
                        <div class="dot-notification">
                            <img src="{{asset('front-end/image/dot.png')}}" alt="">
                        </div>
                        @endif
                    </a>
                    <div class="notification-hover notification-left rounded">
                        <div class="form-notification rounded overflow-hidden">
                            <div class="bg-light px-3 pt-2 w-100">
                                <span class="fs-20 text-dark font-weight-bold">Thông báo</span>
                            </div>
                            <div class="notification-body overflow-auto">
                                @foreach($notifications as $noti)
                                <a href="{{$noti->link}}" class="choose-notification" data-id="{{$noti->id_notification}}">
                                    <div class="d-flex align-item-center justify-content-between px-3 pt-2 cursor-pointer">
                                        <span class="fs-12 d-block text-secondary">{{date('d/m/Y',strtotime($noti->created_at))}}</span>
                                        @if($noti->is_read == 0)
                                        <img src="{{asset('front-end/image/dot.png')}}" alt="">
                                        @endif
                                    </div>
                                    <div class="border-bottom border-secondary px-3 pb-2 cursor-pointer">
                                        <a href="{{$noti->link}}" class="text-light fs-14">{{$noti->content}}</a>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            <span class="text-center fs-15 d-block mt-2 load-more-notification cursor-pointer" data-page="0"><i class="icon-angle-down"></i> Xem thêm</span>
                        </div>
                    </div>
                </li>
                @endif
                @include('home.login')
            </ul>
        </div>
    </div>
</nav>