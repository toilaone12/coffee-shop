<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    function list(){
        $title = 'Danh sách chức vụ';
        $list = Role::all();
        return view('role.list',compact('title','list'));
    }

    function insert(Request $request){
        $data = $request->all();
        Validator::make($data,[
            'name_role' => ['required', 'regex:/^[\p{L}\s\p{P}]+$/u'],
        ],[
            'name_role.required' => 'Tên danh mục bắt buộc phải có',
            'name_role.regex' => 'Tên danh mục phải là chữ cái',
        ])->validate();
        $db = [
            'name_role' => $data['name_role'],
        ];
        $insert = Role::create($db);
        if($insert){
            return redirect()->route('role.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('role.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request){
        $data = $request->all();
        $errors = [];
        if($data['name_role'] == ''){
            $errors['name'] = 'Tên danh mục bắt buộc phải có';
        }else if(!preg_match('/^[\p{L}\s\p{P}]+$/u',$data['name_role'])){
            $errors['name'] = 'Tên danh mục phải là chữ cái';
        }
        if(count($errors) == 0){
            $role = Role::find($data['id_role']);
            $role->name_role = $data['name_role'];
            $update = $role->save();
            if($update){
                return response()->json(['res' => 'success', 'title' => 'Sửa chức vụ', 'icon' => 'success', 'status' => 'Thay đổi dữ liệu thành chức vụ '.$data['name_role'].' thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Sửa chức vụ', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $errors]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Role::find($data['id'])->delete();
        if($delete){
            Account::where('id_role',$data['id'])->delete();
            return response()->json(['res' => 'success', 'title' => 'Xóa chức vụ', 'icon' => 'success', 'status' => 'Xóa thành công'],200);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xóa chức vụ', 'icon' => 'error', 'status' => 'Xóa không thành công'],200);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $delete = Role::where('id_role',$id)->delete();
            if($delete){
                $deleteAccount = Account::where('id_role',$id)->delete();
                $noti += ['res' => 'success'];
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success', 'title' => 'Xóa chức vụ', 'icon' => 'success', 'status' => 'Xóa thành công'],200);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xóa chức vụ', 'icon' => 'error', 'status' => 'Xóa không thành công'],200);
        }
    }
}
