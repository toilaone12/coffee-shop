<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Notification;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    function list(){
        $title = 'Danh sách chức vụ';
        $list = Role::all();
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
        return view('role.list',compact('title','list','notifications','dot'));
    }

    function insert(Request $request){
        $data = $request->all();
        
        Validator::make($data,[
            'name_role' => ['required', 'regex:/^[\p{L}\s\p{P}]+$/u'],
        ],[
            'name_role.required' => 'Tên danh mục bắt buộc phải có',
            'name_role.regex' => 'Tên danh mục phải là chữ cái',
        ])->validate();
        $check = Role::where('name_role', $data['name_role'])->first();
        if(!$check){
            $db = [
                'name_role' => $data['name_role'],
            ];
            $insert = Role::create($db);
            if($insert){
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã thêm chức vụ "'.$data['name_role'].'"',
                    'link' => redirect()->route('role.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                return redirect()->route('role.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
            }else{
                return redirect()->route('role.list')->with('message','<span class="mx-3 text-danger">Lỗi truy vấn!</span>');
            }
        }else{
            return redirect()->route('role.list')->with('message','<span class="mx-3 text-danger">Chức vụ này đã tồn tại!</span>');
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
            $name = $role->name_role;
            $role->name_role = $data['name_role'];
            $update = $role->save();
            if($update){
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã sửa chức vụ "'.$name.'" thành "'.$data['name_role'].'"',
                    'link' => redirect()->route('role.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
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
        $role = Role::find($data['id']);
        if($role){
            $role->delete();
            Account::where('id_role',$data['id'])->delete();
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa chức vụ "'.$role->name_role.'"',
                'link' => redirect()->route('role.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return response()->json(['res' => 'success', 'title' => 'Xóa chức vụ', 'icon' => 'success', 'status' => 'Xóa thành công'],200);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xóa chức vụ', 'icon' => 'error', 'status' => 'Xóa không thành công'],200);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $role = Role::where('id_role',$id)->first();
            $name = $role->name_role;
            if($role){
                $role->delete();
                $deleteAccount = Account::where('id_role',$id)->delete();
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã xóa chức vụ "'.$name.'"',
                    'link' => redirect()->route('role.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
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
