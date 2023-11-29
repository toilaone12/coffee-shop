<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Harper 7 chuyên cung cấp các sản phẩm cà phê chất lượng, đồ uống tươi ngon cùng các loại bánh mì, bánh ngọt và set ăn đa dạng đáp ứng nhu cầu của quý khách">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="harper, harper 7, harper seven, coffee, bakery, roastery, breakfast, brunch, dinner, cà phê, bánh mì, bánh ngọt, ăn sáng ăn trưa, ăn tối, rang xay">
    <link rel="icon" href="https://www.harper7coffee.com/images/favicon.ico" type="image/x-icon">

    <title>{{$title}}</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('./back-end/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('./back-end/css/style.css')}}" rel="stylesheet">
</head>
<?php
    use Illuminate\Support\Facades\Cookie;
    $json_remember = Cookie::get('json_remember');
    if(isset($json_remember)){
        $arrRemember = json_decode($json_remember);
        // print_r($arrRemember->username);
        $remember = $arrRemember->remember;
        $username = $arrRemember->username;
        $password = $arrRemember->password;
    }else{
        $username = '';
        $password = '';
        $remember = '';
    }
?>
<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Chào mừng đến Café Harper Seven!</h1>
                                        <p class="text-danger small">{{session('error')}}</p>
                                    </div>
                                    <form class="user" action="{{route('admin.signIn')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" name="username_account" value="{{$username ? $username : old('username_account')}}" aria-describedby="emailHelp"
                                                placeholder="Nhập tài khoản...">
                                            @error('username_account')
                                            <p class="text-danger small ml-3 mt-1">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 password-container">
                                            <input type="password" name="password_account" value="{{$password ? $password : old('password_account')}}" class="form-control form-control-user"
                                                id="password-login" placeholder="Nhập mật khẩu">
                                            <button type="button" class="password-toggle-login">
                                                <i class="fa-solid fa-eye text-secondary fs-22"></i>
                                            </button>
                                            @error('password_account')
                                            <p class="text-danger small ml-3 mt-1">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="otp-container">
                                                <input type="phone" class="otp-input" maxlength="1" />
                                                <input type="phone" class="otp-input" maxlength="1" />
                                                <input type="phone" class="otp-input" maxlength="1" />
                                                <input type="phone" class="otp-input" maxlength="1" />
                                                <input type="phone" class="otp-input" maxlength="1" />
                                                <input type="phone" class="otp-input" maxlength="1" />
                                            </div>
                                            <input type="hidden" class="otp-account" name="otp_account">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" {{$remember ? 'checked' : ''}} name="remember" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Nhớ tài khoản</label>
                                            </div>
                                        </div>
                                        @error('otp_account')
                                            <p class="text-danger small mb-2">{{$message}}</p>
                                        @enderror
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Đăng nhập
                                        </button>
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="">Quên mật khẩu?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small register">Đăng ký!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="{{asset('./back-end/js/jquery.min.js')}}"></script>
    <script src="{{asset('./back-end/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('./back-end/js/main.js')}}"></script>
    <script src="{{asset('./back-end/js/function.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('./back-end/js/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('./back-end/js/sb-admin-2.min.js')}}"></script>
<!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
</body>

</html>