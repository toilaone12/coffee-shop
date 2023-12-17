<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\CustomerCoupon;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    //admin
    function list(){
        $title = "Danh sách mã khuyến mãi";
        $list = Coupon::all();
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
        return view('coupon.list',compact('title','list','notifications','dot'));
    }

    function insert(Request $request){
        $data = $request->all();
        Validator::make($data,[
            'name_coupon' => ['required'],
            'code_coupon' => ['required','regex: /^[A-Z0-9-]+$/'],
            'quantity_coupon' => ['required'],
            'discount_coupon' => ['required'],
            'expiration_time' => ['required']
        ],[
            'name_coupon.required' => 'Tên mã khuyến mãi bắt buộc phải có',
            'code_coupon.required' => 'Mã khuyến mãi bắt buộc phải có',
            'code_coupon.regex' => 'Mã khuyến mãi bắt buộc phải được viết hoa toàn bộ',
            'quantity_coupon.required' => 'Số lượng mã bắt buộc phải có',
            'discount_coupon.required' => 'Sô tiền được giảm bắt buộc phải có',
            'expiration_time.required' => 'Thời hạn bắt buộc phải có',
        ])->validate();
        $db = [
            'name_coupon' => $data['name_coupon'],
            'code_coupon' => $data['code_coupon'],
            'quantity_coupon' => $data['quantity_coupon'],
            'type_coupon' => $data['type_coupon'],
            'discount_coupon' => $data['discount_coupon'],
            'expiration_time' => $data['expiration_time'],
            'is_buy' => $data['is_buy'] ? $data['is_buy'] : 0,
            'is_price' => $data['is_price'] ? $data['is_price'] : 0,
        ];
        $insert = Coupon::create($db);
        if($insert){
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã thêm mã khuyến mãi "'.$data['name_coupon'].'"',
                'link' => redirect()->route('coupon.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return redirect()->route('coupon.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('coupon.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }
    
    function update(Request $request){
        $data = $request->all();
        $validation =  Validator::make($data,[
            'name_coupon' => ['required'],
            'code_coupon' => ['required','regex: /^[A-Z0-9-]+$/'],
            'quantity_coupon' => ['required'],
            'discount_coupon' => ['required'],
            'expiration_time' => ['required']
        ],[
            'name_coupon.required' => 'Tên mã khuyến mãi bắt buộc phải có',
            'code_coupon.required' => 'Mã khuyến mãi bắt buộc phải có',
            'code_coupon.regex' => 'Mã khuyến mãi bắt buộc phải được viết hoa toàn bộ',
            'quantity_coupon.required' => 'Số lượng mã bắt buộc phải có',
            'discount_coupon.required' => 'Sô tiền được giảm bắt buộc phải có',
            'expiration_time.required' => 'Thời hạn bắt buộc phải có',
        ]);
        if(!$validation->fails()){
            $coupon = Coupon::find($data['id_coupon']);
            $coupon->name_coupon = $data['name_coupon'];
            $coupon->code_coupon = $data['code_coupon'];
            $coupon->quantity_coupon = $data['quantity_coupon'];
            $coupon->type_coupon = $data['type_coupon'];
            $coupon->discount_coupon = $data['discount_coupon'];
            $coupon->is_buy = $data['is_buy'];
            $coupon->is_price = $data['is_price'];
            $coupon->expiration_time = $data['expiration_time'];
            $update = $coupon->save();
            if($update){
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã cập nhật lại "'.$data['name_coupon'].'"',
                    'link' => redirect()->route('coupon.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                return response()->json(['res' => 'success', 'title'=> 'Sửa mã khuyến mãi', 'icon' => 'success', 'status' => 'Thay đổi dữ liệu thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title'=> 'Sửa mã khuyến mãi', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $coupon = Coupon::find($data['id']);
        if($coupon){
            $name = $coupon->name_coupon;
            $coupon->delete();
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa khuyến mãi "'.$name.'"',
                'link' => redirect()->route('coupon.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return response()->json(['res' => 'success', 'title'=> 'Xoá mã khuyến mãi', 'icon' => 'success', 'status' => 'Xóa thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title'=> 'Xoá mã khuyến mãi', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $coupon = Coupon::where('id_coupon',$id)->first();
            if($coupon){
                $name = $coupon->name_coupon;
                $coupon->delete();
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã xóa khuyến mãi "'.$name.'"',
                    'link' => redirect()->route('coupon.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                $noti += ['res' => 'success'];
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success', 'title'=> 'Xoá mã khuyến mãi', 'icon' => 'success', 'status' => 'Xóa thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title'=> 'Xoá mã khuyến mãi', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    //page
    function apply(Request $request){
        $data = $request->all();
        $validation = Validator::make($data,[
            'code_coupon' => ['required']
        ],[
            'code_coupon.required' => 'Bạn phải nhập mã khuyến mãi'
        ]);
        if(!$validation->fails()){
            $coupon = Coupon::where('code_coupon',$data['code_coupon'])
            ->where('expiration_time','>=',date('Y-m-d H:i:s'))->first();
            if($coupon){
                $id = $coupon->id_coupon;
                $checkCouponCustomer = CustomerCoupon::where('id_customer',request()->cookie('id_customer'))
                ->where('id_coupon',$id)->first();
                if($checkCouponCustomer){
                    $type = $coupon->type_coupon;
                    $priceChange = 0;
                    if($type == 0){
                        $priceChange = intval($data['price_cart'] * (intval($coupon->discount_coupon) / 100));
                    }else{
                        $priceChange = $coupon->discount_coupon;
                    }
                    return response()->json(['res' => 'success', 'status' => 'Trả mã giảm giá thành công', 'fee' => $priceChange]);
                }else{
                    return response()->json(['res' => 'warning', 'status' => 'Bạn không có mã khuyến mãi này']);
                }
            }else{
                return response()->json(['res' => 'warning', 'status' => 'Mã khuyến mãi này không tồn tại hoặc đã hết hạn']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => 'Bạn phải nhập mã khuyến mãi']);
        }
    }

    function home(){
        $title = 'Mã khuyến mãi';
        $lists = CustomerCoupon::where('id_customer',request()->cookie('id_customer'))->get();
        $arrCoupon = [];
        foreach($lists as $key => $one){
            $coupon = Coupon::where('id_coupon',$one->id_coupon)->where('expiration_time','>=',date('Y-m-d H:i:s'))->get();
            if(count($coupon) != 0){
                foreach($coupon as $key => $one){
                    $arr = [
                        'name' => $one->name_coupon,
                        'code' => $one->code_coupon,
                        'discount' => $one->discount_coupon,
                        'type' => $one->type_coupon,
                        'expiration' => $one->expiration_time,
                    ];
                    array_push($arrCoupon,$arr);
                }
            }else{
                $arrCoupon = [];
            }
        }
        $arrCoupon = collect($arrCoupon);
        $carts = array();
        $notifications = array();
        $isDot = '';
        if(request()->cookie('id_customer')){
            $customer = Customer::find(request()->cookie('id_customer'));
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
            $notifications = Notification::where('id_customer', request()->cookie('id_customer'))->orderBy('id_notification','desc')->limit(7)->get();
            $isDot = Notification::where('id_customer', request()->cookie('id_customer'))->where('is_read',0)->orderBy('id_notification','desc')->get();
        }
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        return view('coupon.home',compact('customer','title','arrCoupon','parentCategorys','childCategorys','carts','notifications','isDot'));
    }
}
