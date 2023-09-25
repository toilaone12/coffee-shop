<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //admin
    function list(){
        $title = 'Danh sách khách hàng';
        $list = Customer::all();
        return view('customer.list',compact('title','list'));
    }
    //page
    function register(Request $request) {
        $data = $request->all();
        $validation = Validator::make($data,[
            'name' => ['required', 'regex: /^[\p{L}a-zA-Z\s]+$/u'],
            'email' => ['required'],
            'password' => ['required', 'regex:/^[A-Za-z0-9]{6,32}+$/'],
            'repassword' => ['required', 'same:password']
        ],[
            'name.required' => 'Họ và tên bắt buộc phải điền vào',
            'name.regex' => 'Họ và tên bắt buộc phải là chữ cái',
            'email.required' => 'Email bắt buộc phải điền vào',
            'password.required' => 'Mật khẩu bắt buộc phải điền vào',
            'password.regex' => 'Mật khẩu bắt buộc phải từ 6 đến 32 ký tự',
            'repassword.required' => 'Mật khẩu nhập lại bắt buộc phải điền vào',
            'repassword.same' => 'Hai mật khẩu không giống nhau',
        ]);
        if(!$validation->fails()){
            $data = [
                'image_customer' => asset('storage/customer/person.svg'),
                'name_customer' => $data['name'],
                'gentle_customer' => 0,
                'email_customer' => $data['email'],
                'password_customer' => md5($data['password']),
                'is_vip' => 0
            ];
            $register = Customer::create($data);
            if($register){
                return response()->json(['res' => 'success', 'title' => 'Đăng ký tài khoản', 'icon' => 'success', 'status' => 'Đăng ký tài khoản thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Đăng ký tài khoản', 'icon' => 'error', 'status' => 'Đăng ký tài khoản thất bại']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }

    function login(Request $request) {
        $data = $request->all();
        $validation = Validator::make($data, [
            'email' => ['required'],
            'password' => ['required', 'regex:/^[A-Za-z0-9]{6,32}+$/'],
        ],[
            'email.required' => 'Email bắt buộc phải điền vào',
            'password.required' => 'Mật khẩu bắt buộc phải điền vào',
            'password.regex' => 'Mật khẩu bắt buộc phải từ 6 đến 32 ký tự',
        ]);
        if(!$validation->fails()){
            $login = Customer::where('email_customer', $data['email'])
            ->where('password_customer',md5($data['password']))->first();
            if($login){
                Session::put('id_customer',$login->id_customer);
                return response()->json(['res' => 'success', 'title' => 'Đăng nhập tài khoản', 'icon' => 'success', 'status' => 'Đăng nhập tài khoản thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Đăng nhập tài khoản', 'icon' => 'error', 'status' => 'Đăng nhập tài khoản thất bại']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }
}
