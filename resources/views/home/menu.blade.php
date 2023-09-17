<section class="ftco-menu">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <h2 class="mb-4">Món Best Seller</h2>
            </div>
        </div>
        <div class="row d-md-flex">
            <div class="col-lg-12 ftco-animate p-md-5">
                <div class="row">
                    <div class="col-md-12 nav-link-wrap mb-5">
                        <div class="nav ftco-animate nav-pills justify-content-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach($parentCategorys as $key => $parent)
                            <a 
                                class="nav-link {{$key == 0 ? 'active' : ''}}" 
                                id="v-pills-{{$key}}-tab" 
                                data-toggle="pill" 
                                href="#v-pills-{{$key}}" 
                                role="tab" 
                                aria-controls="v-pills-{{$key}}" 
                                aria-selected="true"
                            >
                                {{$parent->name_category}}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12 d-flex align-items-center">
                        <div class="tab-content ftco-animate w-100" id="v-pills-tabContent">
                            @foreach($parentCategorys as $key => $parent)
                            <div class="tab-pane fade {{$key == 0 ? 'show active' : ''}}" id="v-pills-{{$key}}" role="tabpanel" aria-labelledby="v-pills-{{$key}}-tab">
                                <div class="row">
                                    @foreach($childCategorys as $child)
                                    @if($child->id_parent_category == $parent->id_category)
                                    @foreach($products as $product)
                                    @if($child->id_category == $product->id_category)
                                    <div class="col-md-4 text-center">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url('{{asset($product->image_product)}}');"></a>
                                            <div class="text">
                                                <h3><a href="#">{{$product->name_product}}</a></h3>
                                                <p class="price"><span>{{$product->price_product}} đ</span></p>
                                                <p><a href="#" class="btn btn-primary btn-outline-primary">Đặt hàng</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>