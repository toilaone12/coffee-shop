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
                    <a class="nav-link">
                        <span class="icon icon-shopping_cart"></span>
                        <span class="bag d-flex justify-content-center align-items-center"><small>1</small></span>
                    </a>
                    <div class="cart-hover left rounded">
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>