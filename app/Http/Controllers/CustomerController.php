<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Random;

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
        if (isset($data['remember']) && $data['remember'] == 'on') {
            $arrRemember = [
                'email' => $data['email'],
                'password' => $data['password'],
                'remember' => 'on'
            ];
            $jsonRemember = json_encode($arrRemember);
            Cookie::queue('json_remember_customer', $jsonRemember, 2628000);
        } else {
            $jsonRemember = Cookie::get('json_remember_customer');
            if (isset($jsonRemember)) {
                Cookie::queue(Cookie::forget('json_remember_customer'));
            }
        }
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
                if(session('cart')){
                    Session::forget('cart');
                }
                Cookie::queue('id_customer',$login->id_customer);
                Cookie::queue('name_customer',$login->name_customer);
                return response()->json(['res' => 'success', 'title' => 'Đăng nhập tài khoản', 'icon' => 'success', 'status' => 'Đăng nhập tài khoản thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Đăng nhập tài khoản', 'icon' => 'error', 'status' => 'Đăng nhập tài khoản thất bại']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }

    function forgot(Request $request){
        $data = $request->all();
        $validation = Validator::make($data,[
            'email_forgot' => ['required']
        ],[
            'email_forgot.required' => 'Email không được để trống'
        ]);
        if($validation->fails()){
            return response()->json(['res' => 'warning','status' => $validation->errors()]);
        }else{
            $email = $data['email_forgot'];
            $newPassword = rand(100000,999999);
            $customer = Customer::where('email_customer',$email)->first();
            if($customer){
                $customer->password_customer = md5($newPassword);
                $update = $customer->save();
                if($update){
                    $titleMail = 'Quên mật khẩu tại Café Harper 7 Coffee';
                    $dataMail = [
                        'email' => $email,
                        'password' => $newPassword
                    ];
                    Mail::send('mail.forgot',$dataMail,function($message) use ($titleMail,$email){
                        $message->to($email)->subject($titleMail);
                        $message->from($email,$titleMail);
                    });
                    return response()->json(['res' => 'success', 'title' => 'Quên mật khẩu', 'icon' => 'success', 'status' => 'Bạn hãy vào email vừa xác nhận để nhận mật khẩu mới']);
                }
            }else{
                return response()->json(['res' => 'warning','status' => ['email_forgot' => 'Email này chưa được đăng ký tại đây']]);
            }
        }
    }

    function logout() {
        Cookie::queue(Cookie::forget('id_customer'));
        Cookie::queue(Cookie::forget('name_customer'));
        return response()->json(['res' => 'success', 'status' => 'Đăng xuất tài khoản', 'icon' => 'success', 'title' => 'Đăng xuất tài khoản thành công'], 200);
    }

    function home(){
        $title = 'Thông tin cá nhân';
        $id = request()->cookie('id_customer');
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        $customer = Customer::find($id);
        $carts = array();
        if(request()->cookie('id_customer')){
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
        }
        return view('customer.home',compact(
            'title',
            'parentCategorys',
            'childCategorys',
            'carts',
            'customer'
        ));
    }
}
