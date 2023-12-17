@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách danh mục</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Tên danh mục</th>
                                    <th>Thuộc danh mục</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td></td>
                                    <td><input type="checkbox" name="" value="{{$one->id_category}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="name-{{$one->id_category}}">{{$one->name_category}}</td>
                                    @php
                                        $foundParent = false;
                                    @endphp
                                    @foreach($listParent as $key => $parent)
                                        @if($parent->id_category == $one->id_parent_category)
                                            <td class="id-parent-{{$one->id_category}}" data-id="{{$one->id_parent_category}}">{{$parent->name_category}}</td>
                                            @php
                                                $foundParent = true;
                                                break;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if(!($foundParent))
                                        <td class="id-parent-{{$one->id_category}}" data-id="{{$one->id_parent_category}}">Không có</td>
                                    @endif
                                    <td>
                                        <button class="btn btn-primary choose-category" data-id="{{$one->id_category}}" data-toggle="modal" data-target="#updateModal"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="btn btn-danger delete-category" data-id="{{$one->id_category}}"><i class="fa-solid fa-trash-can"></i></button>
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
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm danh mục</button>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-category d-block mb-3">Xóa nhiều</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('category.insert')}}" method="post">
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
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Tên danh mục (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                                    <input type="text" name="name_category" id="name" class="form-control">
                                    @error('name_category')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="option">Thuộc danh mục (<span title="Bắt buộc phải chọn" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                                    <select name="id_parent_category" id="" class="form-control">
                                        <option value="0" class="form-control">Danh mục gốc</option>
                                        @foreach($listParent as $key => $parent)
                                        <option value="{{$parent->id_category}}" class="form-control">{{$parent->name_category}}</option>
                                        @endforeach
                                    </select>
                                    @error('id_parent_category')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
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

    <!-- Modal Update -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span class="text-success message-category mx-3"></span>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Tên danh mục (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                                <input type="text" name="" id="name" class="form-control name-update">
                                <span class="text-danger error-name"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="option">Thuộc danh mục (<span title="Bắt buộc phải chọn" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                                <select name="id_parent_category" id="" class="form-control id-parent-update">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary update-category">Sửa</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- End of Main Content -->

</div>
@endsection