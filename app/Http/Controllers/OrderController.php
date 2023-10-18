<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //
    function list(){
        $title = 'Danh sách đơn hàng';
        $list = Order::all();
        return view('order.list',compact('title','list'));
    }

    function apply(Request $request){
        $data = $request->all();
        $validation = Validator::make($data,[
            'fullname_order' => ['required', 'regex:/^[a-zA-Z\sÀ-Ỹà-ỹ-]+$/u'],
            'phone_order' => ['required', 'regex:/^(03[2-9]|05[6-9]|07[06-9]|08[1-9]|09[0-9]|01[2-9])[0-9]{7}$/', 'max:10'],
            'address_order' => ['required'] 
        ],[
            'fullname_order.required' => 'Họ tên người đặt không được để trống',
            'fullname_order.regex' => 'Họ tên người đặt phải là chữ cái',
            'phone_order.regex' => 'Số điện thoại người đặt phải là số',
            'phone_order.required' => 'Số điện thoại người đặt không được để trống',
            'phone_order.max' => 'Số điện thoại người đặt phải là số điện thoại tại Việt Nam',
            'address_order.required' => 'Địa chỉ người đặt không được để trống',
        ]);
        if(!$validation->fails()){
            
        }else{
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }
}
