<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    //
    function list(){
        $title = 'Danh sách nhà cung cấp';
        $list = Supplier::all();
        return view('supplier.list',compact('title','list'));
    }

    function insert(Request $request){
        $data = $request->all();
        Validator::make($data,[
            'name_supplier' => ['required'],
            'phone_supplier' => ['required','regex:/^(03[2-9]|05[6-9]|07[06-9]|08[1-9]|09[0-9]|01[2-9])[0-9]{7}$/'],
            'address_supplier' => ['required']
        ],[
            'name_supplier.required' => 'Tên nhà cung cấp bắt buộc phải có',
            'phone_supplier.required' => 'Số điện thoại nhà cung cấp bắt buộc phải có',
            'phone_supplier.regex' => 'Số điện thoại phải đủ 10 số và nằm trong quốc gia Việt Nam',
            'address_supplier.required' => 'Địa chỉ nhà cung cấp bắt buộc phải có'
        ])->validate();
        $db = [
            'name_supplier' => $data['name_supplier'],
            'phone_supplier' => $data['phone_supplier'],
            'address_supplier' => $data['address_supplier'],
        ];
        $insert = Supplier::create($db);
        if($insert){
            return redirect()->route('supplier.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('supplier.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request){
        $data = $request->all();
        $errors = [];
        if($data['name_supplier'] == ''){
            $errors['name'] = 'Tên nhà cung cấp bắt buộc phải có';
        }
        if($data['phone_supplier'] == ''){
            $errors['phone'] = 'Số điện thoại nhà cung cấp bắt buộc phải có';
        }else if(!preg_match('/^(03[2-9]|05[6-9]|07[06-9]|08[1-9]|09[0-9]|01[2-9])[0-9]{7}$/',$data['phone_supplier'])){
            $errors['phone'] = 'Số điện thoại phải đủ 10 số và nằm trong quốc gia Việt Nam';
        }
        if($data['address_supplier'] == ''){
            $errors['address'] = 'Địa chỉ nhà cung cấp bắt buộc phải có';
        }
        if(count($errors) == 0){
            $supplier = Supplier::find($data['id_supplier']);
            $supplier->name_supplier = $data['name_supplier'];
            $supplier->phone_supplier = $data['phone_supplier'];
            $supplier->address_supplier = $data['address_supplier'];
            $update = $supplier->save();
            if($update){
                return response()->json(['res' => 'success', 'status' => 'Thay đổi dữ liệu thành nhà cung cấp '.$data['name_supplier'].' thành công']);
            }else{
                return response()->json(['res' => 'fail', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $errors]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Supplier::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }
}
