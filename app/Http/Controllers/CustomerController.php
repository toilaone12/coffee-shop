<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    //admin
    function list(){
        $title = 'Danh sách khách hàng';
        $list = Customer::all();
        $notifications = Notification::where('id_account',request()->cookie('id_account'))->orderBy('id_notification','desc')->limit(7)->get();
        $all = Notification::where('id_account',request()->cookie('id_account'))->get();
        $dot = false;
        foreach($all as $noti){
            if($noti->is_read == 0){
                $dot = true;
            }else{
                $dot = false;
            }
        }
        return view('customer.list',compact('title','list','notifications','dot'));
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
                'image_customer' => 'storage/customer/person.svg',
                'name_customer' => $data['name'],
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
                Cookie::queue('image_customer',$login->image_customer);
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
        $isDot = '';
        $carts = array();
        $notifications = array();
        if(request()->cookie('id_customer')){
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
            $notifications = Notification::where('id_customer', request()->cookie('id_customer'))->orderBy('id_notification','desc')->limit(7)->get();
            $isDot = Notification::where('id_customer', request()->cookie('id_customer'))->where('is_read',0)->orderBy('id_notification','desc')->get();
        }
        // dd($customer);
        return view('customer.home',compact(
            'title',
            'parentCategorys',
            'childCategorys',
            'carts',
            'customer',
            'isDot',
            'notifications'
        ));
    }

    function update(Request $request){
        $data = $request->all();
        $validation = Validator::make($data,[
            'fullname' => ['required', 'regex: /^[\p{L}a-zA-Z\s]+$/u'],
            'phone' => ['required', 'regex: /^(03[2-9]|05[6-9]|07[06-9]|08[1-9]|09[0-9]|01[2-9])[0-9]{7}$/'],
            'email' => ['required'],
        ],[
            'fullname.required' => 'Họ và tên bắt buộc phải điền vào',
            'fullname.regex' => 'Họ và tên phải là chữ cái',
            'phone.required' => 'Số điện thoại bắt buộc phải điền vào',
            'phone.regex' => 'Số điện thoại phải nằm trong phạm vi Việt Nam',
            'email.required' => 'Email bắt buộc phải điền vào',
        ]);
        if($validation->fails()){
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }else{
            $image = $request->file('image');
            $slug = Str::slug($data['fullname'], '-');
            $fileName = $slug . '-' . strtotime(now()) . '.jpg';
            if($image){
                $checkImageOriginal = Storage::disk('public')->exists($data['image_original']);
                $image->storeAs('public/customer', $fileName); // se luu vao storage/app
                if($checkImageOriginal){
                    Storage::disk('public')->delete('customer/'.$data['image_original']);
                }
            }
            $customer = Customer::find($data['id']);
            $customer->image_customer = $image ? 'storage/customer/'.$fileName : $data['image_original'];
            $customer->name_customer = $data['fullname'];
            $customer->phone_customer = $data['phone'];
            $update = $customer->save();
            if($update){
                return response()->json(['res' => 'success', 'title' => 'Cập nhật thông tin', 'icon' => 'success', 'status' => 'Đã cập nhật thông tin cá nhân thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Cập nhật thông tin', 'icon' => 'error', 'status' => 'Đã cập nhật thông tin cá nhân thất bại']);
            }
        }
    }

    function updatePassword(Request $request){
        $data = $request->all();
        $validation = Validator::make($data,[
            'password' => ['required', 'regex:/^[A-Za-z0-9]{6,32}+$/'],
            'repassword' => ['required', 'regex:/^[A-Za-z0-9]{6,32}+$/', 'same:password'],
        ],[
            'password.required' => 'Mật khẩu mới không được để trống',
            'password.regex' => 'Mật khẩu phải từ 6 đến 32 ký tự',
            'repassword.required' => 'Mật khẩu nhập lại không được để trống',
            'repassword.regex' => 'Mật khẩu phải từ 6 đến 32 ký tự',
            'repassword.same' => 'Hai mật khẩu phải trùng khớp với nhau',
        ]);
        if($validation->fails()){
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }else{
            $customer = Customer::find($data['id']);
            $customer->password_customer = md5($data['password']);
            $update = $customer->save();
            if($update){
                return response()->json(['res' => 'success', 'title' => 'Cập nhật mật khẩu', 'icon' => 'success', 'status' => 'Đã cập nhật mật khẩu thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Cập nhật mật khẩu', 'icon' => 'error', 'status' => 'Đã cập nhật mật khẩu thất bại']);
            }
        }
    }
}
