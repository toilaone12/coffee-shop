@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-10 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách sản phẩm</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Danh mục</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Tiêu đề</th>
                                    <th>Tồn</th>
                                    <th>Đã bán</th>
                                    <th>Giá cả</th>
                                    <th>Mô tả</th>
                                    <th>Số lần đánh giá</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    @foreach($listCate as $key => $cate)
                                    @if($cate->id_category == $one->id_category)
                                        <td class="id-category-{{$one->id_product}}" data-id="{{$one->id_category}}">
                                            {{$cate->name_category}}
                                        </td>
                                    @endif
                                    @endforeach
                                    <td>
                                        <img loading="lazy" src="{{ asset($one->image_product) }}" data-name="{{$one->image_product}}" class="image-{{$one->id_product}}" width="120" height="120" alt="" srcset="">
                                    </td>
                                    <td class="name-{{$one->id_product}}">{{$one->name_product}}</td>
                                    <td class="subname-{{$one->id_product}}">{{$one->subname_product}}</td>
                                    <td class="quantity-{{$one->id_product}}">{{$one->quantity_product}}</td>
                                    <td class="quantity-sold-{{$one->id_product}}">{{$one->quantity_sold_product ? $one->quantity_sold_product : 0}}</td>
                                    <td class="price-{{$one->id_product}}">{{$one->price_product}}</td>
                                    <td class="description-{{$one->id_product}}">{{$one->description_product}}</td>
                                    <td class="number-reviews-{{$one->id_product}}">{{$one->number_reviews_product}}</td>
                                    <td>
                                        <button style="width: 45px;" class="btn mb-1 btn-primary update-product-{{$one->id_product}} product" data-id="{{$one->id_product}}" data-toggle="modal" data-target="#updateModal">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button style="width: 45px;" class="btn mb-1 btn-danger delete-product" data-id="{{$one->id_product}}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <a href="{{route('gallery.list',['id'=>$one->id_product])}}" style="width: 45px;" class=" text-white btn mb-1 btn-danger add-gallery-product">
                                            <i class="fa-solid fa-images"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-xl-2 col-lg-6 col-sm-3 ">
                <div class="card">
                    <h5 class="card-header">Thao tác chung</h5>
                    <div class="card-body">
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm sản phẩm</button>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-product d-block mb-3">Xóa nhiều</button>
                        <button class="w-100 btn btn-primary choose-all d-block">Chọn nhiều</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Insert -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('product.insert')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <?php

                    use Illuminate\Support\Facades\Session;

                    $message = Session::get('message');
                    if (isset($message)) {
                        echo $message;
                        Session::put('message', '');
                    }
                    ?>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-lg-7">
                                    <label>Hình ảnh sản phẩm</label>
                                    <div class="custom-file mt-4">
                                        <input type="file" class="custom-file-input change-image" name="image_product" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Chọn ảnh</label>
                                    </div>
                                    <p class="imagePath" class="mt-5"></p>
                                    @error('image_product')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Hình ảnh gốc</label>
                                        <img loading="lazy" class="image-update img-thumbnail d-block" style="height: 100px;" width="150" src="https://s2s.co.th/wp-content/uploads/2019/09/photo-icon-1.jpg" class="mt-5">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id">Danh mục sản phẩm</label>
                            <select name="id_category" class="form-control" id="id">
                                @foreach($listCate as $key => $cate)
                                <option value="{{$cate->id_category}}">{{$cate->name_category}}</option>
                                @endforeach
                            </select>
                            @error('id_category')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" name="name_product" id="name" class="form-control">
                                    @error('name_product')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="subname">Tiêu đề sản phẩm</label>
                                    <input type="text" name="subname_product" id="subname" class="form-control">
                                    @error('subname_product')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="quantity">Số lượng sản phẩm</label>
                                    <input type="number" min=0 name="quantity_product" id="quantity" class="form-control">
                                    @error('quantity_product')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="price">Giá cả sản phẩm</label>
                                    <input type="number" min=0 name="price_product" id="price" class="form-control">
                                    @error('price_product')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ckeditor1">Mô tả sản phẩm</label>
                            <textarea class="form-control" id="ckeditor1" name="description_product" rows="3" placeholder="Nhập mô tả">
                            </textarea>
                            @error('description_product')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- Modal Update -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span class="text-success message-product mx-3"></span>
                <form class="update-product" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <div class="row">
                                <input type="hidden" name="id_product" class="id-product" >
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Hình ảnh gốc</label>
                                        <img class="image-update img-thumbnail d-block" width="200" height="100" src="" class="mt-5">
                                        <input type="hidden" name="image_original_product" class="image-original">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <label>Hình ảnh sản phẩm</label>
                                    <div class="custom-file mt-4">
                                        <input type="file" class="custom-file-input change-original-image" name="image_product" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Chọn ảnh</label>
                                    </div>
                                    <div class="fs-16 mt-2 name-image"></div>
                                    <span class="text-danger error-image"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="option">Thuộc danh mục</label>
                            <select name="id_category" id="" class="form-control id-category-update">
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" name="name_product" id="name" class="form-control name-update">
                                    <span class="text-danger error-name"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="subname">Tiêu đề sản phẩm</label>
                                    <input type="text" name="subname_product" id="subname" class="form-control subname-update">
                                    <span class="text-danger error-subname"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="quantity">Số lượng sản phẩm</label>
                                    <input type="number" min=0 name="quantity_product" id="quantity" class="form-control quantity-update">
                                    <span class="text-danger error-quantity"></span>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="price">Giá sản phẩm</label>
                                    <input type="number" min=0 name="price_product" id="price" class="form-control price-update">
                                    <span class="text-danger error-price"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ckeditor1">Mô tả sản phẩm</label>
                            <textarea class="form-control description-update" id="ckeditor" name="description_product" rows="3" placeholder="Nhập mô tả">
                            </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- End of Main Content -->

</div>
@endsection