@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-12 col-lg-6 col-sm-3">
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
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
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
                                    <td class="phone-{{$one->id_customer}}">{{$one->phone_customer}}</td>
                                    <td class="email-{{$one->id_customer}}">{{$one->email_customer}}</td>
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