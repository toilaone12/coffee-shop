@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách chi tiết phiếu hàng ({{$list[0]->code_note}})</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Mã phiếu</th>
                                    <th>Tên nguyên liệu</th>
                                    <th>Đơn vị</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <!-- <th>Chức năng</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" name="" value="{{$one->id_detail}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="code-{{$one->id_detail}}">{{$one->code_note}}</td>
                                    <td class="name-{{$one->id_detail}}">{{$one->name_ingredient}}</td>
                                    @foreach($listUnit as $key => $unit)
                                    @if($unit->id_unit == $one->id_unit)
                                    <td class="id-unit-{{$one->id_detail}}">{{$unit->name_unit}}</td>
                                    @endif
                                    @endforeach
                                    <td class="quantity-{{$one->id_detail}}">{{$one->quantity_ingredient}}</td>
                                    <td class="price-{{$one->id_detail}}">{{$one->price_ingredient}}</td>
                                    <!-- <td>
                                        <button class="btn btn-primary update-note-{{$one->id_detail}} note" data-id="{{$one->id_detail}}" data-toggle="modal" data-target="#updateModal"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="btn btn-info open-detail"><i class="fa-solid fa-list"></i></button>
                                        <button class="btn btn-danger delete-note" data-id="{{$one->id_detail}}"><i class="fa-solid fa-trash-can"></i></button>
                                    </td> -->
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
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Nhập phiếu</button>
                        <!-- <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Xuất phiếu</button> -->
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-unit d-block mb-3">Xóa nhiều</button>
                        <button class="w-100 btn btn-primary choose-all d-block">Chọn nhiều</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection