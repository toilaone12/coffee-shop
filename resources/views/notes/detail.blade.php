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
                                    <th>Chức năng</th>
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
                                    <td class="id-unit-{{$one->id_detail}}">{{$unit->fullname_unit}} ({{$unit->abbreviation_unit}})</td>
                                    @endif
                                    @endforeach
                                    <td class="quantity-{{$one->id_detail}}">{{$one->quantity_ingredient}}</td>
                                    <td class="price-{{$one->id_detail}}">{{$one->price_ingredient}}</td>
                                    <td>
                                        @if($note->status_note == 0)
                                        <button class="btn btn-danger delete-detail-note" data-id="{{$one->id_detail}}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        @endif
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
                        <a href="#" class="text-white btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#note">
                            In phiếu hàng (bằng PDF)
                        </a>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-detail d-block mb-3">Xóa nhiều</button>
                        <button class="w-100 btn btn-primary choose-all d-block">Chọn nhiều</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Invoice -->
<div class="modal fade" id="note" tabindex="-1" role="dialog" aria-labelledby="noteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noteLabel">Chi tiết phiếu hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body form-detail-note">
                        <div class="row">
                            <div class="col-xl-12 fs-30">
                                Harper 7 Coffee
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-7">
                                <ul class="list-unstyled float-start">
                                    <li style="font-size: 25px;">Nhà cung cấp</li>
                                    <li>Tên nhà cung cấp: {{$supplier->name_supplier}}</li>
                                    <li>Số điện thoại: {{$supplier->phone_supplier}}</li>
                                    <li>Địa chỉ: {{$supplier->address_supplier}}</li>
                                </ul>
                            </div>
                            <div class="col-xl-5">
                                <ul class="list-unstyled float-end">
                                    <li style="font-size: 25px; color: red;">Cửa hàng</li>
                                    <li>104A Nhà D2, 215 Tô Hiệu, Dịch Vọng, Cầu Giấy</li>
                                    <li>(+84) 985 104 987</li>
                                    <li>harper7coffee@gmail.com</li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-center mt-3 fs-28">Phiếu hàng #{{$note->code_note}}</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nguyên liệu</th>
                                    <th scope="col" class="text-center">Số lượng</th>
                                    <th scope="col" class="text-center">Đơn vị tính</th>
                                    <th scope="col" class="text-center">Đơn giá (Trên 1 sản phẩm)</th>
                                    <th scope="col" class="text-center">Giá thành</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $allTotal = 0; @endphp
                                @foreach($list as $one)
                                @php $allTotal +=$one->price_ingredient * $one->quantity_ingredient; @endphp
                                <tr>
                                    <td>{{$one->name_ingredient}}</td>
                                    <td class="text-center">x{{$one->quantity_ingredient}}</td>
                                    @foreach($listUnit as $unit)
                                    @if($unit->id_unit == $one->id_unit)
                                    <td class="text-center">{{$unit->abbreviation_unit}}</td>
                                    @endif
                                    @endforeach
                                    <td class="text-center">{{number_format($one->price_ingredient,0,',','.')}} đ</td>
                                    <td class="text-center">{{number_format($one->price_ingredient * $one->quantity_ingredient,0,',','.')}} đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-xl-12">
                                <ul class="list-unstyled float-start ms-4">
                                    <li><span class="float-start mr-1">Tổng tiền phải thanh toán: </span>{{number_format($allTotal,0,',','.')}} đ</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary export-detail-note">Xác nhận</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Invoice -->
@endsection