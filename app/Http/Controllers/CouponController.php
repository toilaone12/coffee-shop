<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    //
    function list(){
        $title = "Danh sách mã khuyến mãi";
        $list = Coupon::all();
        return view('coupon.list',compact('title','list'));
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
        $delete = Coupon::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $delete = Coupon::where('id_coupon',$id)->delete();
            if($delete){
                $noti += ['res' => 'success'];
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }
}
