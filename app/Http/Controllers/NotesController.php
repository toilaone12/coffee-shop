<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Notes;
use App\Models\Supplier;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{
    //
    function list(){
        $title = 'Danh sách phiếu hàng';
        $list = Notes::all();
        $listSupplier = Supplier::all();
        $listUnit = Units::all();
        return view('notes.list',compact('title','list','listSupplier','listUnit'));
    }

    function insert(Request $request){
        $data = $request->all();
        $codeNote = $this->randomCode();
        $validator = Validator::make($data,[
            'name_note' => ['required'],
            'quantity_note' => ['required'],
        ],[
            'name_note.required' => 'Tên phiếu hàng bắt buộc phải điền vào',
            'quantity_note.required' => 'Tổng số lượng các nguyên liệu bắt buộc phải điền vào',
        ]);
        if(!$validator->fails()){
            // $db = [
            //     'id_supplier' => $data['id_supplier'],
            //     'code_note' => $codeNote,
            //     'name_note' => $data['name_note'],
            //     'quantity_note' => $data['quantity_note'],
            //     'status_note' => 0
            // ];
            // $insert = Notes::create($db);
            $insert = true;
            if($insert){
                $result = [
                    'id_note' => 1,
                    'code_note' => $codeNote,
                    'quantity_note' => $data['quantity_note']
                ];
                return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Thêm thành công', 'status' => 'Bạn đã thêm phiếu thành công.', 'result' => $result],200);           
            }else{
                return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Thêm thất bại', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    // function update(Request $request){
    //     $data = $request->all();
    //     $errors = [];
    //     if($data['name_role'] == ''){
    //         $errors['name'] = 'Tên danh mục bắt buộc phải có';
    //     }else if(!preg_match('/^[\p{L}\s\p{P}]+$/u',$data['name_role'])){
    //         $errors['name'] = 'Tên danh mục phải là chữ cái';
    //     }
    //     if(count($errors) == 0){
    //         $role = Role::find($data['id_role']);
    //         $role->name_role = $data['name_role'];
    //         $update = $role->save();
    //         if($update){
    //             return response()->json(['res' => 'success', 'status' => 'Thay đổi dữ liệu thành chức vụ '.$data['name_role'].' thành công']);
    //         }else{
    //             return response()->json(['res' => 'fail', 'status' => 'Lỗi truy vấn dữ liệu']);
    //         }
    //     }else{
    //         return response()->json(['res' => 'warning', 'status' => $errors]);
    //     }
    // }

    // function delete(Request $request){
    //     $data = $request->all();
    //     $delete = Role::find($data['id'])->delete();
    //     if($delete){
    //         $deleteAccount = Account::where('id_role',$data['id'])->delete();
    //         if($deleteAccount){
    //             return response()->json(['res' => 'success'],200);
    //         }else{
    //             return response()->json(['res' => 'fail'],200);
    //         }
    //     }else{
    //         return response()->json(['res' => 'fail'],200);
    //     }
    // }

    // function deleteAll(Request $request){
    //     $data = $request->all();
    //     $noti = [];
    //     foreach($data['arrId'] as $key => $id){
    //         $delete = Role::where('id_role',$id)->delete();
    //         if($delete){
    //             $deleteAccount = Account::where('id_role',$id)->delete();
    //             if($deleteAccount){
    //                 $noti += ['res' => 'success'];
    //             }else{
    //                 $noti += ['res' => 'fail'];
    //             }
    //         }else{
    //             $noti += ['res' => 'fail'];
    //         }
    //     }
    //     if($noti['res'] == 'success'){
    //         return response()->json(['res' => 'success'],200);
    //     }else{
    //         return response()->json(['res' => 'fail'],200);
    //     }
    // }

    function randomCode($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
