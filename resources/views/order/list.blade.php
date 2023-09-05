@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách đơn hàng</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Mã đơn</th>
                                    <th>Tên khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Tình trạng đơn</th>
                                    <th>Ngày tạo đơn</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" value="{{$one->id_order}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="code-{{$one->id_order}}">{{$one->code_order}}</td>
                                    <td class="name-{{$one->id_order}}">{{$one->name_order}}</td>
                                    <td class="total-{{$one->id_order}}">{{$one->total_order}}</td>
                                    <td class="status-{{$one->id_order}}">{{$one->status_order}}</td>
                                    <td class="">{{$one->created_at}}</td>
                                    <td>
                                        <button class="btn btn-info open-detail-order" data-id="{{$one->id_order}}"><i class="fa-solid fa-clipboard-list"></i></button>
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
                        <!-- <button class="w-100 btn btn-primary open-detail-order d-block">Chi tiết</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->

</div>
@endsection