@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách nhà cung cấp</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Tên nhà cung cấp</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="name-{{$one->id_supplier}}">{{$one->name_supplier}}</td>
                                    <td class="phone-{{$one->id_supplier}}">{{$one->phone_supplier}}</td>
                                    <td class="address-{{$one->id_supplier}}">{{$one->address_supplier}}</td>
                                    <td>
                                        <button class="btn btn-primary update-supplier-{{$one->id_supplier}} supplier" data-id="{{$one->id_supplier}}" data-toggle="modal" data-target="#updateModal"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="btn btn-danger delete-supplier" data-id="{{$one->id_supplier}}"><i class="fa-solid fa-trash-can"></i></button>
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
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm nhà cung cấp</button>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-supplier d-block mb-3">Xóa nhiều</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm nhà cung cấp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('supplier.insert')}}" method="post">
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
                        <div class="form-group">
                            <label for="name">Tên nhà cung cấp</label>
                            <input type="text" name="name_supplier" id="name" class="form-control">
                            @error('name_supplier')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại liên hệ</label>
                            <input type="phone" max=10 min=0 name="phone_supplier" id="phone" class="form-control">
                            @error('phone_supplier')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" name="address_supplier" id="address" class="form-control">
                            @error('address_supplier')
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

    <!-- Modal Insert -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa nhà cung cấp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span class="text-success message-supplier mx-3"></span>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Tên nhà cung cấp</label>
                        <input type="text" name="" id="name" class="form-control name-update">
                        <span class="text-danger error-name"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại liên hệ</label>
                        <input type="phone" max=10 min=0 name="" id="phone" class="form-control phone-update">
                        <span class="text-danger error-phone"></span>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" name="address_supplier" id="address" class="form-control address-update">
                        <span class="text-danger error-address"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary update-supplier">Sửa</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- End of Main Content -->

</div>
@endsection