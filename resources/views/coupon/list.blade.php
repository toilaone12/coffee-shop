@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách mã khuyến mãi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Tên khuyến mãi</th>
                                    <th>Mã khuyến mãi</th>
                                    <th>Số lượng mã</th>
                                    <th>Thể loại giảm giá</th>
                                    <th>Giảm giá</th>
                                    <th>Thời hạn hết khuyến mãi</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" value="{{$one->id_coupon}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="name-{{$one->id_coupon}}">{{$one->name_coupon}}</td>
                                    <td class="code-{{$one->id_coupon}}">{{$one->code_coupon}}</td>
                                    <td class="quantity-{{$one->id_coupon}}">{{$one->quantity_coupon}}</td>
                                    <td class="type-{{$one->id_coupon}}">{{$one->type_coupon}}</td>
                                    <td class="discount-{{$one->id_coupon}}">{{$one->discount_coupon}}</td>
                                    <td class="time-{{$one->id_coupon}}">{{$one->expiration_time}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary update-coupon-{{$one->id_coupon}} coupon" 
                                            data-id="{{$one->id_coupon}}" 
                                            data-toggle="modal" 
                                            data-target="#updateModal"
                                            >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger delete-coupon" data-id="{{$one->id_coupon}}"><i class="fa-solid fa-trash-can"></i></button>
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
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm khuyến mãi</button>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-role d-block mb-3">Xóa nhiều</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Thêm khuyến mãi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('coupon.insert')}}" method="post">
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
                                    <label for="name">Tên khuyến mãi</label>
                                    <input type="text" name="name_coupon" id="name" class="form-control">
                                    @error('name_coupon')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="code">Mã khuyến mãi</label>
                                    <input type="text" name="code_coupon" id="code" class="form-control">
                                    @error('code_coupon')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="quantity">Số lượng</label>
                                    <input type="number" min=1 name="quantity_coupon" id="quantity" class="form-control">
                                    @error('quantity_coupon')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="type">Loại giảm giá</label>
                                    <select name="type_coupon" id="type" class="form-control">
                                        <option value="0">Theo phần trăm</option>
                                        <option value="1">Theo giá tiền</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="discount">Giá được trừ</label>
                                    <input type="number" min=1 name="discount_coupon" id="discount" class="form-control">
                                    @error('discount_coupon')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="time">Thời hạn</label>
                                    <input type="datetime-local" min="{{ date('Y-m-d\TH:i') }}" name="expiration_time" id="time" class="form-control change-datetime">
                                    @error('expiration_time')
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
                    <h5 class="modal-title" id="exampleModalLabel">Sửa chức vụ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span class="text-success message-role mx-3"></span>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Tên chức vụ</label>
                        <input type="text" name="" id="name" class="form-control name-update">
                        <span class="text-danger error-name"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary update-role">Sửa</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- End of Main Content -->

</div>
@endsection