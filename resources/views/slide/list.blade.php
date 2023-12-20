@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách quảng cáo</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Hình ảnh quảng cáo</th>
                                    <th>Tên quảng cáo</th>
                                    <th>Slug</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td></td>
                                    <td><input type="checkbox" name="" value="{{$one->id_slide}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        <img loading="lazy" src="{{ asset($one->image_slide) }}" data-name="{{$one->image_slide}}" class="image-{{$one->id_slide}}" width="220" height="100" alt="" srcset="">
                                    </td>
                                    <td class="name-{{$one->id_slide}}">{{$one->name_slide}}</td>
                                    <td class="slug-{{$one->id_slide}}">{{$one->slug_slide}}</td>
                                    <td>
                                        <button class="btn btn-primary choose-slide slide" data-id="{{$one->id_slide}}" data-toggle="modal" data-target="#updateModal"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="btn btn-danger delete-slide" data-id="{{$one->id_slide}}"><i class="fa-solid fa-trash-can"></i></button>
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
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm quảng cáo</button>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-slide d-block mb-3">Xóa nhiều</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm quảng cáo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('slide.insert')}}" method="post" enctype="multipart/form-data">
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
                                    <label>Hình ảnh quảng cáo (<span title="Bắt buộc phải chọn" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input change-image" name="image_slide" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Chọn ảnh</label>
                                    </div>
                                    <p class="imagePath" class="mt-5"></p>
                                    @error('image_slide')
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
                            <label for="name">Tên quảng cáo (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                            <input type="text" name="name_slide" id="name" class="form-control">
                            @error('name_slide')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                            <input type="text" name="slug_slide" id="slug" class="form-control">
                            @error('slug_slide')
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

    <!-- Modal update -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa quảng cáo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span class="text-success message-slide mx-3"></span>
                <form class="update-slide" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <div class="row">
                                <input type="hidden" name="id_slide" class="id-slide">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Hình ảnh gốc</label>
                                        <img class="image-update img-thumbnail d-block" width="200" height="100" src="" class="mt-5">
                                        <input type="hidden" name="image_original_slide" class="image-original">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <label>Hình ảnh quảng cáo (<span title="Bắt buộc phải chọn" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input change-original-image" name="image_slide" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Chọn ảnh</label>
                                    </div>
                                    <div class="fs-16 mt-2 name-image"></div>
                                    <span class="text-danger error-image"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Tên quảng cáo (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                            <input type="text" name="name_slide" id="name" class="form-control name-update">
                            <span class="text-danger error-name"></span>
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                            <input type="text" name="slug_slide" id="slug" class="form-control slug-update">
                            <span class="text-danger error-slug"></span>
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
    <!-- End Modal Update -->

    <!-- End of Main Content -->

</div>
@endsection