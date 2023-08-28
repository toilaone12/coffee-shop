<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //
    function list(){
        $title = 'Danh sách tài khoản';
        $list = Account::all();
        $listRole = Role::all();
        return view('account.list',compact('title','list','listRole'));
    }

    function insert(Request $request){
        $data = $request->all();
        $otp = rand(100000,999999);
        $fullname = 'UID-'.rand(10000,99999);
        $titleMail = 'Tạo tài khoản thành công';
        $email = $data['email_account'];
        $username = $data['username_account'];
        $password = $data['password_account'];
        Validator::make($data,[
            'username_account' => ['required'],
            'password_account' => ['required', 'regex:/^[A-Za-z0-9]{6,32}+$/'],
            're_password_account' => ['required', 'same:password_account', 'regex:/^[A-Za-z0-9]{6,32}+$/'],
        ],[
            'username_account.required' => 'Vui lòng nhập tên tài khoản.',
            'password_account.required' => 'Vui lòng nhập mật khẩu.',
            're_password_account.required' => 'Vui lòng nhập lại mật khẩu.',
            're_password_account.same' => 'Mật khẩu và mật khẩu xác nhận không khớp.',
            '*.regex' => 'Mật khẩu chỉ được chứa chữ cái và số và phải từ 6 ký tự.',
        ])->validate();
        $checkEmail = Account::where('email_account',$email)->orWhere('username_account',$username)->first();
        if($checkEmail){
            return redirect()->route('account.list')->with('message','<span class="mx-3 text-success">Email của bạn đã tồn tại!</span>');
        }else{
            $dataMail = [
                'name' => $fullname,
                'username' => $username,
                'email' => $email,
                'otp' => $otp,
                'password' => $password
            ];
            $mail = Mail::send('mail.create',$dataMail,function($message) use ($titleMail,$email){
                $message->to($email)->subject($titleMail);
                $message->from($email,$titleMail);
            });
            if($mail == null){
                $db = [
                    'fullname_account' => $fullname,
                    'username_account' => $data['username_account'],
                    'email_account' => $data['email_account'],
                    'password_account' => md5($data['password_account']),
                    'id_role' => $data['id_role'],
                    'otp_account' => $otp,
                    'is_online' => 0,
                ];
                $insert = Account::create($db);
                if($insert){
                    return redirect()->route('account.list')->with('message','<span class="mx-3 mt-2 text-success">Đăng ký thành công, vui lòng kiểm tra email đã đăng ký</span>');
                }else{
                    return redirect()->route('account.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
                }
            }
        }
    }

    function updateInfo(Request $request){
        $data = $request->all();
        Validator::make($data,[
            'fullname_account' => ['regex:/^[a-zA-Z\sÀ-Ỹà-ỹ-]+$/u'],
            'password_account' => ['regex:/^[A-Za-z0-9]{6,32}+$/'],
            're_password_account' => ['same:password_account', 'regex:/^[A-Za-z0-9]{6,32}+$/'],
            'otp_account' => ['size:6']
        ],[
            're_password_account.same' => 'Mật khẩu và mật khẩu xác nhận không khớp.',
            'password_account.regex' => 'Mật khẩu chỉ được chứa chữ cái và số và phải từ 6 ký tự.',
            're_password_account.regex' => 'Mật khẩu chỉ được chứa chữ cái và số và phải từ 6 ký tự.',
            'fullname_account.regex' => 'Tài khoản phải là chữ cái',
            'otp_account.size' => 'Mã xác nhận phải đủ 6 số.',
        ])->validate();
        $account = Account::find($data['id_account']);
        $account->fullname_account = $data['fullname_account'];
        $account->username_account = $data['username_account'];
        $account->password_account = md5($data['password_account']);
        $account->otp_account = $data['otp_account'];
        $update = $account->save();
        if($update){
            return redirect()->route('account.setting')->with('message','<span class="mx-3 mt-2 text-success">Cập nhật thông tin thành công!</span>');
        }else{
            return redirect()->route('account.setting')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Account::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    function setting(){
        $title = "Cài đặt";
        $id = Cookie::get('id_account');
        $one = Account::find($id);
        return view('account.setting',compact('title','one'));
    }
}
