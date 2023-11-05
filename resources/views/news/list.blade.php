@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách tin tức</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Ảnh tin tức</th>
                                    <th>Tiêu đề</th>
                                    <th>Phụ đề</th>
                                    <th>Nội dung</th>
                                    <th>Lượt xem</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" value="{{$one->id_new}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        <img width="200" height="100" src="{{asset($one->image_new)}}" class="image-{{$one->id_new}}" data-name="{{$one->image_new}}" alt="">
                                    </td>
                                    <td class="title-{{$one->id_new}}">{{$one->title_new}}</td>
                                    <td class="subtitle-{{$one->id_new}}">{{$one->subtitle_new ? $one->subtitle_new : 'Không có'}}</td>
                                    <td style="width: 100px; max-width: 100px;" class="text-truncate content-{{$one->id_new}}">{{$one->content_new}}</td>
                                    <td class="view-{{$one->id_new}}">{{$one->view_new}}</td>
                                    <td>
                                        <button 
                                            style="width: 40px; height: 40px;"
                                            class="btn btn-primary choose-new mb-2" 
                                            data-id="{{$one->id_new}}" 
                                            data-toggle="modal" 
                                            data-target="#updateModal"
                                            >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button style="width: 40px; height: 40px;" class="btn btn-danger delete-new" data-id="{{$one->id_new}}"><i class="fa-solid fa-trash-can"></i></button>
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
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm tin tức</button>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-news d-block mb-3">Xóa nhiều</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm tin tức</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('news.insert')}}" method="post" enctype="multipart/form-data">
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
                            <div class="row">
                                <div class="col-lg-7">
                                    <label>Hình ảnh tin tức</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input change-image" name="image_new" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Chọn ảnh</label>
                                    </div>
                                    <p class="imagePath" class="mt-5"></p>
                                    @error('image_new')
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
                            <label for="name">Tiêu đề</label>
                            <input type="text" name="title_new" id="name" class="form-control">
                            @error('title_new')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="subtitle">Phụ đề</label>
                            <input type="text" name="subtitle_new" id="subtitle" class="form-control">
                            @error('subtitle_new')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="ckeditor1">Nội dung</label>
                            <textarea class="form-control" id="ckeditor1" name="content_new" rows="3" placeholder="Nhập mô tả">
                            </textarea>
                            @error('content_new')
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
                    <h5 class="modal-title" id="exampleModalLabel">Sửa tin tức</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="update-new" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <div class="row">
                                <input type="hidden" name="id_new" class="id-new" >
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Hình ảnh gốc</label>
                                        <img class="image-update img-thumbnail d-block" width="200" height="100" src="" class="mt-5">
                                        <input type="hidden" name="image_original_new" class="image-original">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <label>Hình ảnh quảng cáo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input change-original-image" name="image_new" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Chọn ảnh</label>
                                    </div>
                                    <div class="fs-16 mt-2 name-image"></div>
                                    <span class="text-danger error-image"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Tiêu đề</label>
                            <input type="text" name="title_new" id="title" class="form-control title-update">
                            <span class="text-danger error-title"></span>
                        </div>
                        <div class="form-group">
                            <label for="subtitle">Phụ đề</label>
                            <input type="text" name="subtitle_new" id="subtitle" class="form-control subtitle-update">
                            <span class="text-danger error-subtitle"></span>
                        </div>
                        <div class="form-group">
                            <label for="subtitle">Nội dung</label>
                            <textarea name="content_new" id="ckeditor" cols="30" rows="10"></textarea>
                            <span class="text-danger error-subtitle"></span>
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