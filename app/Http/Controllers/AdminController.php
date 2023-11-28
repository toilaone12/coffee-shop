<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\DetailOrder;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Statistic;
use Carbon\Carbon;
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
            $statistic = Statistic::where('date_statistic',date('Y-m-d'))->first();
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
            // $order = Order::where('date_updated',date('Y-m-d'))->get();
            $order = Order::where('date_updated',date('Y-m-d'))->get();
            $arrDetail = [];
            foreach($order as $key => $one){
                if($one->status_order == 3){
                    $orderDetail = DetailOrder::where("id_order",$one->id_order)->get();
                    foreach($orderDetail as $key => $detail){
                        $name = $detail->name_product;
                        $quantity = $detail->quantity_product;
                        // Nếu sản phẩm đã tồn tại trong mảng $arrDetail
                        $existingKey = array_search($name, array_column($arrDetail, 'name')); //array_column: tao 1 mang moi chi co cot name
                        //existingKey se tra ve key dung
                        if ($existingKey !== false) {
                            // Tăng số lượng cho sản phẩm đã tồn tại
                            $arrDetail[$existingKey]['quantity'] += $quantity;
                        } else {
                            // Thêm sản phẩm mới vào mảng
                            $arrDetail[] = [
                                'name' => $name,
                                'quantity' => $quantity,
                            ];
                        }
                    }
                }
            }
            $arrFilter = [
                '7days' => 'Một tuần trước',
                '1month' => 'Một tháng trước',
                '3months' => 'Ba tháng trước',
            ];
            $arrFilter = collect($arrFilter);
            $firstDayOfMonth = Carbon::now()->startOfMonth(); // Lấy ngày đầu tiên của tháng này
            $lastDayOfMonth = Carbon::now()->endOfMonth(); // Lấy ngày cuối cùng của tháng này
            $statisticMonth = Statistic::whereBetween('date_statistic',[$firstDayOfMonth,$lastDayOfMonth])->get();
            $allTotal = 0;
            foreach($statisticMonth as $key => $one){
                $allTotal+= $one->price_statistic;
            }
            // dd($allTotal);
            return view('admin.content', compact('title','isOnline','statistic','allTotal','arrDetail','arrFilter','firstDayOfMonth','notifications','dot'));
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
        // dd(md5($data['password_account']));
        if ($signIn) {
            $account = Account::find($signIn->id_account);
            $account->is_online = 1;
            $online = $account->save();
            if($online){
                Cookie::queue('username', $data['username_account'], 2628000);
                Cookie::queue('fullname', $signIn->fullname_account, 2628000);
                Cookie::queue('id_account',$signIn->id_account, 2628000);
                return redirect()->route('admin.dashboard');
            }
        } else {
            return redirect()->route('admin.login');
        }
    }

    function logout(){
        Cookie::queue(Cookie::forget('username'));
        Cookie::queue(Cookie::forget('fullname'));
        $id = Cookie::get('id_account');
        $account = Account::find($id);
        $account->is_online = 0;
        $offline = $account->save();
        if($offline){
            Cookie::queue(Cookie::forget('id_account'));
            return response()->json(['res' => 'success'], 200);
        }
    }
}
