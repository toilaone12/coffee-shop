<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\News;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
        // $order = session('order');
        // if(isset($order)){
        //     Session::flush('order');
        // }
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
            $order = [
                'fullname' => $data['fullname_order'],
                'phone' => $data['phone_order'],
                'address' => $data['address_order'],
                'fee_ship' => $data['fee_ship'],
                'fee_discount' => $data['fee_discount'],
            ];
            Session::put('order',$order);
            return response()->json(['res' => 'success']);
        }else{
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }

    function home(){
        $title = 'Đơn hàng';
        $cart = session('cart');
        $order = session('order');
        $idCustomer = request()->cookie('id_customer') ? request()->cookie('id_customer') : 0;
        $customer = request()->cookie('id_customer') ? Customer::find($idCustomer) : [];
        $list = Cart::where('id_customer',$idCustomer)->get();
        $news = News::orderBy('updated_at', 'desc')->limit(3)->get();
        $carts = array();
        $subtotal = 0;
        $total = 0;
        if(request()->cookie('id_customer')){
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
            foreach($carts as $key => $one){
                $subtotal += intval($one['price_product']);
            }
            $total += $subtotal + intval($order['fee_ship']) - intval($order['fee_discount']);
        }else{
            foreach($cart as $key => $one){
                $subtotal += intval($one['price_product']);
            }
            $total = $subtotal + intval($order['fee_ship']) - intval($order['fee_discount']);
        }
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        return view('order.home',compact('list','title','parentCategorys','childCategorys','order','subtotal','total','news'));
    }

    function order(Request $request){
        $data = $request->all();
        $order = session('order');
        $cart = '';
        if(request()->cookie('id_customer')){
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
        }else{

        }
        if(isset($data['privacy'])){
            $dataOrder = [
                'code_order' => $this->randomCode(),
                'name_order' => $order['fullname'],
                'total_order' => $order
            ];
            // $order = 
        }else{
            return response(['res' => 'warning', 'status' => 'Hãy đồng ý với yêu cầu!']);
        }
    }

    function randomCode($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
