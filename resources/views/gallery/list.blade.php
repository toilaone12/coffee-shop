@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách hình ảnh</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Hình ảnh sản phẩm</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        <label for="file-{{$one->id_gallery}}">
                                            <img loading="lazy" src="{{ asset($one->image_gallery) }}" data-name="{{$one->image_gallery}}" class="" width="220" height="100" alt="" srcset="">
                                        </label>
                                        <input type="file" class="mt-3 d-none update-gallery"  data-gallery="{{$one->id_gallery}}" name="image_gallery" id="file-{{$one->id_gallery}}">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger delete-gallery" data-id="{{$one->id_gallery}}"><i class="fa-solid fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-3 ">
                <div class="card">
                    <h5 class="card-header">Thao tác chung</h5>
                    <div class="card-body">
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm hình ảnh</button>
                        <a href="#" class="btn btn-primary delete-all d-block mb-3">Xóa nhiều</a>
                        <a href="#" class="btn btn-primary choose-all d-block">Chọn nhiều</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm quảng cáo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('gallery.insert')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <?php
                    use Illuminate\Support\Facades\Session;
                    $message = Session::get('message');
                    if(isset($message)){
                        echo $message;
                        Session::put('message','');
                    }
                    ?>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <input type="hidden" name="id_product" value="{{$id}}">
                            <div class="row">
                                <div class="col-lg-7">
                                    <label>Hình ảnh</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input change-multi-image" name="image_gallery[]"  multiple accept="image/*">
                                        <label class="custom-file-label" for="inputGroupFile01">Chọn ảnh</label>
                                    </div>
                                    <p class="imagePath" class="mt-5"></p>
                                    @error('image_gallery')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Hình ảnh gốc</label>
                                        <img loading="lazy" class="image-update img-thumbnail d-block" style="height: 100px;" width="150" src="https://s2s.co.th/wp-content/uploads/2019/09/photo-icon-1.jpg" class="mt-5">
                                        <div class="gallery-array"></div>
                                    </div>
                                </div>
                            </div>
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

    <!-- End of Main Content -->

</div>
@endsection