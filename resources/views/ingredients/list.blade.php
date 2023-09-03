@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách nguyên liệu</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Tên nguyên liệu</th>
                                    <th>Đơn vị tính</th>
                                    <th>Số lượng có</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="name-{{$one->id_ingredient}}">{{$one->name_ingredient}}</td>
                                    @foreach($listUnits as $unit)
                                    @if($unit->id_unit == $one->id_unit)
                                    <td 
                                        class="id-{{$one->id_ingredient}}" 
                                        data-id="{{$one->id_unit}}"
                                    >
                                        {{$unit->fullname_unit}}
                                    </td>
                                    @endif
                                    @endforeach
                                    <td class="quantity-{{$one->id_ingredients}}">{{$one->quantity_ingredient}}</td>
                                    <td>
                                        <button class="btn btn-primary update-ingredients-{{$one->id_ingredient}} ingredients" data-id="{{$one->id_ingredient}}" data-toggle="modal" data-target="#updateModal"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <!-- <button class="btn btn-danger delete-ingredients" data-id="{{$one->id_ingredient}}"><i class="fa-solid fa-trash-can"></i></button> -->
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
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-category d-block mb-3">Xóa nhiều</button>
                        <button class="w-100 btn btn-primary choose-all d-block">Chọn nhiều</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa nguyên liệu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span class="text-success message-category mx-3"></span>
                <form class="update-ingredient">
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id_ingredient" class="id-ingredient">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Tên nguyên liệu</label>
                                    <input type="text" name="name_ingredient" id="name" class="form-control name-update">
                                    <span class="text-danger error-name"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="option">Đơn vị tính</label>
                                    <select name="id_unit" id="" class="form-control id-unit-update">
                                    </select>
                                </div>
                            </div>
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