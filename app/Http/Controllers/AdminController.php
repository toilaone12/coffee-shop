<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    function dashboard() {
        $title = 'Trang chủ';
        $username = Cookie::get('username');
        if(isset($username) && $username != ''){
            $isOnline = Account::where('is_online',1)->get();
            return view('admin.content', compact('title','isOnline'));
        }else{
            return redirect()->route('admin.login');
        }
    }

    function login(){
        $title = 'Đăng nhập';
        return view('admin.login', compact('title'));
    }

    function signIn(Request $request){
        $data = $request->all();
        if (isset($data['remember']) && $data['remember'] == 'on') {
            $arrRemember = [
                'username' => $data['username_account'],
                'password' => $data['password_account'],
                'remember' => 'on'
            ];
            $jsonRemember = json_encode($arrRemember);
            Cookie::queue('json_remember', $jsonRemember, 2628000);
        } else {
            $jsonRemember = Cookie::get('json_remember');
            if (isset($jsonRemember)) {
                Cookie::queue(Cookie::forget('json_remember'));
            }
        }
        Validator::make($data, [
            'username_account' => ['required'],
            'password_account' => ['required', 'min:6', 'max:32'],
            'otp_account' => ['required', 'size:6'],
        ], [
            'username_account.required' => 'Tài khoản không được để trống dữ liệu',
            'password_account.required' => 'Mật khẩu không được để trống dữ liệu',
            'password_account.min' => 'Mật khẩu phải ít nhất có 6 ký tự',
            'password_account.max' => 'Mật khẩu phải nhiều nhất có 32 ký tự',
            'otp_account.required' => 'Mã xác nhận không được để trống dữ liệu',
            'otp_account.size' => 'Mã xác nhận phải đủ 6 số',
        ])->validate();
        $signIn = Account::where('username_account', $data['username_account'])
        ->where('password_account', md5($data['password_account']))
        ->where('otp_account',$data['otp_account'])->first();
        if ($signIn) {
            $account = Account::find($signIn->id_account);
            $account->is_online = 1;
            $online = $account->save();
            if($online){
                Cookie::queue('username', $data['username_account'], 2628000);
                Cookie::queue('id_account',$signIn->id_account, 2628000);
                return redirect()->route('admin.dashboard');
            }
        } else {
            return redirect()->route('admin.login');
        }
    }

    function logout(){
        Cookie::queue(Cookie::forget('username'));
        $id = Cookie::get('id_account');
        $account = Account::find($id);
        $account->is_online = 0;
        $offline = $account->save();
        if($offline){
            return response()->json(['res' => 'success'], 200);
        }
    }
}
