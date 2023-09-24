<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{route('page.home')}}">Harper 7<small>Coffee</small></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span>
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="{{route('page.home')}}" class="nav-link fs-13">Trang chủ</a></li>
                <li class="nav-item"><a href="services.html" class="nav-link fs-13">Tin tức</a></li>
                <li class="nav-item dropdown">
                    <span class="nav-link dropdown-toggle fs-13" id="dropdown04">
                        Thực đơn
                    </span>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        @foreach($parentCategorys as $parent)
                        <div class="nav-item-child">
                            <a class="nav-link fs-13 dropdown-toggle" id="dropdown05">
                                {{$parent->name_category}}
                            </a>
                            <div class="dropdown-submenu">
                                @foreach($childCategorys as $child)
                                @if($child->id_parent_category == $parent->id_category)
                                <a class="dropdown-item p-3 fs-13 text-white" href="">{{$child->name_category}}</a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item"><a href="" class="nav-link fs-13">Giới thiệu</a></li>
                <li class="nav-item"><a href="" class="nav-link fs-13">Liên hệ</a></li>
                <li class="nav-item cart dropdown">
                    <a class="nav-link" style="cursor: pointer;">
                        <span class="icon icon-shopping_cart"></span>
                        <div class="dot-cart">
                            @php
                            $cart = session('cart');
                            @endphp
                            @if(isset($cart))
                            <span class="bag d-flex justify-content-center align-items-center"><small>{{count($cart)}}</small></span>
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
                        @endif
                    </div>
                </li>
                <li class="nav-item">
                    <p data-toggle="modal" data-target="#userModal" class="nav-link fs-13 cursor-pointer">
                        <span class="fs-20 icon-user-circle-o"></span>
                    </p>
                </li>
                @include('home.login')
            </ul>
        </div>
    </div>
</nav>