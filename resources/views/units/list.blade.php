@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách đơn vị tính</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Tên đầy đủ</th>
                                    <th>Ký hiệu</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td></td>
                                    <td><input type="checkbox" name="" value="{{$one->id_unit}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="fullname-{{$one->id_unit}}">{{$one->fullname_unit}}</td>
                                    <td class="abbreviation-{{$one->id_unit}}">{{$one->abbreviation_unit}}</td>
                                    <td>
                                        <button class="btn btn-primary choose-unit" data-id="{{$one->id_unit}}" data-toggle="modal" data-target="#updateModal"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="btn btn-danger delete-unit" data-id="{{$one->id_unit}}"><i class="fa-solid fa-trash-can"></i></button>
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
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm đơn vị</button>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-unit d-block mb-3">Xóa nhiều</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm đơn vị tính</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('units.insert')}}" method="post">
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
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="fullname">Tên đơn vị (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                                    <input type="text" name="fullname_unit" id="fullname" class="form-control">
                                    @error('fullname_unit')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="abbreviation">Ký hiệu (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                                    <input type="text" name="abbreviation_unit" id="abbreviation" class="form-control">
                                    @error('abbreviation_unit')
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
                    <h5 class="modal-title" id="exampleModalLabel">Sửa đơn vị tính</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span class="text-success message-unit mx-3"></span>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="fullname">Tên đơn vị (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                                <input type="text" name="" id="fullname" class="form-control fullname-update">
                                <span class="text-danger error-fullname"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="abbreviation">Ký hiệu (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                                <input type="text" name="" id="abbreviation" class="form-control abbreviation-update">
                                <span class="text-danger error-abbreviation"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary update-unit">Sửa</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- End of Main Content -->

</div>
@endsection