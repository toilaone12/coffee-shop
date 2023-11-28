@extends('dashboard')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="row">
            <div class="col-xl-12">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Thông tin tài khoản</div>
                    <?php

                    use Illuminate\Support\Facades\Session;
                    $message = Session::get('message');
                    if(isset($message)){
                        echo $message;
                        Session::put('message', '');

                    }
                    ?>
                    
                    <div class="card-body">
                        <form method="POST" action="{{route('account.update')}}">
                            @csrf
                            <input type="hidden" name="id_account" value="{{$one->id_account}}">
                            <!-- Form Group (username)-->
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">Họ và tên</label>
                                    <input class="form-control" id="inputFirstName" name="fullname_account" value="{{$one->fullname_account}}" type="text" placeholder="Nhập tên">
                                    @error('fullname_account')
                                    <span class="text-danger small">{{$message}}</span>
                                    @enderror
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLastName">Tên đăng nhập</label>
                                    <input class="form-control" id="inputLastName" name="username_account" value="{{$one->username_account}}" type="text" placeholder="Nhập tên đăng nhập">
                                    @error('username_account')
                                    <span class="text-danger small">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-4">
                                    <label class="small mb-1" for="inputPhone">Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" name="password_account">
                                    <button type="button" class="password-toggle-btn" style="top: 47px !important; right: 15px !important;">
                                        <i class="fa-solid fa-eye text-secondary"></i>
                                    </button>
                                    @error('password_account')
                                    <span class="text-danger small">{{$message}}</span>
                                    @enderror
                                </div>
                                <!-- Form Group (birthday)-->
                                <div class="col-md-4">
                                    <label class="small mb-1" for="inputBirthday">Nhập lại mật khẩu</label>
                                    <input type="password" class="form-control" id="re-password" name="re_password_account">
                                    <button type="button" class="re-password-toggle-btn" style="top: 47px !important; right: 15px !important;">
                                        <i class="fa-solid fa-eye text-secondary"></i>
                                    </button>
                                    @error('re_password_account')
                                    <span class="text-danger small">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="small mb-1" for="inputBirthday">Mã bảo mật</label>
                                    <input class="form-control" id="inputBirthday" type="tel" value="{{$one->otp_account}}" name="otp_account" placeholder="Nhập mã bảo mật">
                                    @error('otp_account')
                                    <span class="text-danger small">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary rounded" type="submit">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection