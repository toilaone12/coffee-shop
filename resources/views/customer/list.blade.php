@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-10 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách khách hàng</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Hình ảnh</th>
                                    <th>Họ và tên</th>
                                    <th>Giới tính</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Thuộc khách hàng</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        <img 
                                            loading="lazy" 
                                            src="{{ asset($one->image_customer) }}" 
                                            data-name="{{$one->image_customer}}" 
                                            class="image-{{$one->id_customer}}" 
                                            width="120" 
                                            height="120"
                                        >
                                    </td>
                                    <td class="name-{{$one->id_customer}}">{{$one->name_customer}}</td>
                                    <td class="gentle-{{$one->id_customer}}">{{$one->gentle_customer}}</td>
                                    <td class="phone-{{$one->id_customer}}">{{$one->phone_customer}}</td>
                                    <td class="email-{{$one->id_customer}}">{{$one->email_customer}}</td>
                                    <td class="vip-{{$one->id_customer}}">{{$one->is_vip}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-xl-2 col-lg-6 col-sm-3 ">
                <div class="card">
                    <h5 class="card-header">Thao tác chung</h5>
                    <div class="card-body">
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm sản phẩm</button>
                        <a href="#" class="btn btn-primary delete-all d-block mb-3">Xóa nhiều</a>
                        <a href="#" class="btn btn-primary choose-all d-block">Chọn nhiều</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Main Content -->

</div>
@endsection