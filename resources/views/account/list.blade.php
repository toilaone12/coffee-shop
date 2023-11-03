@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách tài khoản</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Họ và tên</th>
                                    <th>Tên tài khoản</th>
                                    <th>Email đăng ký</th>
                                    <th>Chức vụ</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" value="{{$one->id_account}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="name-{{$one->id_account}}">{{$one->fullname_account}}</td>
                                    <td class="username-{{$one->id_account}}">{{$one->username_account}}</td>
                                    <td class="email-{{$one->id_account}}">{{$one->email_account}}</td>
                                    @foreach($listRole as $key => $role)
                                    @if($one->id_role == $role->id_role)
                                    <td class="role-{{$one->id_account}}">{{$role->name_role}}</td>
                                    @endif
                                    @endforeach
                                    <td>
                                        <button class="btn btn-danger delete-account" data-id="{{$one->id_account}}"><i class="fa-solid fa-trash-can"></i></button>
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
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Đăng ký tài khoản</button>
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#permissionModal">Phân quyền</button>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-account d-block mb-3">Xóa nhiều</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Đăng ký tài khoản</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('account.insert')}}" method="post">
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
                                    <label for="name">Tên tài khoản</label>
                                    <input type="text" name="username_account" id="name" class="form-control">
                                    @error('username_account')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="option">Chức vụ</label>
                                    <select name="id_role" id="" class="form-control">
                                        @foreach($listRole as $key => $role)
                                        <option value="{{$role->id_role}}" class="form-control">{{$role->name_role}}</option>
                                        @endforeach
                                    </select>
                                    @error('id_role')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email đăng ký</label>
                            <input type="email" name="email_account" id="email" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3 password-container">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" name="password_account">
                                    <button type="button" class="password-toggle-btn">
                                        <i class="fa-solid fa-eye text-secondary"></i>
                                    </button>
                                    @error('password_account')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 password-container">
                                    <label for="re-password" class="form-label">Nhập lại mật khẩu</label>
                                    <input type="password" class="form-control" id="re-password" name="re_password_account">
                                    <button type="button" class="re-password-toggle-btn">
                                        <i class="fa-solid fa-eye text-secondary"></i>
                                    </button>
                                    @error('re_password_account')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->


    <!-- End of Main Content -->

</div>
@endsection