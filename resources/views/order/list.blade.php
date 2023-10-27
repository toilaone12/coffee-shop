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
                                    <td 
                                    class="text-light status-{{$one->id_order}} {{$one->status_order == 0 || $one->status_order == 1 ? 'bg-warning' : ($one->status_order == 2 || $one->status_order == 3 ? 'bg-success' : 'bg-danger')}}">
                                        {{$one->status_order == 0 ? 'Khách đặt hàng' : ($one->status_order == 1 ? 'Đang chế biến' : ($one->status_order == 2 ? 'Đang vận chuyển' : ($one->status_order == 3 ? 'Giao cho khách thành công' : 'Khách đã hủy đơn')))}}
                                    </td>
                                    <td class="">{{$one->created_at}}</td>
                                    <td>
                                        <a href="{{route('order.adDetail',['code' => $one->code_order])}}" class="btn btn-info text-white" data-id="{{$one->id_order}}"><i class="fa-solid fa-clipboard-list"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->

</div>
@endsection