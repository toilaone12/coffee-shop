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
                            <a class="nav-link {{$key == 0 ? 'active' : ''}}" id="v-pills-{{$key}}-tab" data-toggle="pill" href="#v-pills-{{$key}}" role="tab" aria-controls="v-pills-{{$key}}" aria-selected="true">
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
                                    <?php $productCount = 0; ?>
                                    @foreach($childCategorys as $child)
                                    @if($child->id_parent_category == $parent->id_category)
                                    @foreach($products as $product)
                                    @if($child->id_category == $product->id_category && $productCount < 3) 
                                    <div class="col-md-4 text-center">
                                        <div class="menu-wrap">
                                            <a href="{{route('product.detail',['slug' => $product->slug_product])}}" class="menu-img img mb-4 image-{{$product->id_product}}" style="background-image: url('{{asset($product->image_product)}}');" data-image="{{asset($product->image_product)}}">
                                            </a>
                                            <div class="text">
                                                <h3><a href="{{route('product.detail',['slug' => $product->slug_product])}}" class="name-{{$product->id_product}}">{{$product->name_product}}</a></h3>
                                                <p class="price price-{{$product->id_product}}"><span>{{number_format($product->price_product,0,',','.')}} đ</span></p>
                                                <p>
                                                    <button type="button" class="btn btn-primary btn-outline-primary open-modal-{{$product->id_product}} product" data-toggle="modal" data-target="#exampleModal" data-id="{{$product->id_product}}">
                                                        Đặt hàng
                                                    </button>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <?php $productCount++; ?>
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