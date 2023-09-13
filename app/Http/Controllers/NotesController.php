<?php

namespace App\Http\Controllers;

use App\Models\DetailNote;
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
        $codeNote = $data['code_note'] ? $data['code_note'] : $this->randomCode();
        $validator = Validator::make($data,[
            'name_note' => ['required'],
            'quantity_note' => ['required'],
        ],[
            'name_note.required' => 'Tên phiếu hàng bắt buộc phải điền vào',
            'quantity_note.required' => 'Tổng số lượng các nguyên liệu bắt buộc phải điền vào',
        ]);

        if(!$validator->fails()){
            $result = [
                'id_supplier' => $data['id_supplier'],
                'code_note' => $codeNote,
                'quantity_note' => $data['quantity_note']
            ];
            return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Thêm thành công', 'status' => 'Bạn đã thêm phiếu thành công.', 'result' => $result],200);           
        }else{
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    function update(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'name_note' => ['required'],
            'quantity_note' => ['required'],
        ],[
            'name_note.required' => 'Tên phiếu hàng bắt buộc phải điền vào',
            'quantity_note.required' => 'Tổng số lượng các nguyên liệu bắt buộc phải điền vào',
        ]);
        if(!$validator->fails()){
            $list = DetailNote::where('id_note',$data['id'])->get();
            $result = [
                'id_supplier' => $data['id_supplier'],
                'code_note' => $list[0]->code_note,
                'quantity_note' => $data['quantity_note'],
                'list' => $list,
            ];
            return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Sửa thành công', 'status' => 'Bạn đã sửa phiếu thành công.', 'result' => $result],200);           
        }else{
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Notes::find($data['id'])->delete();
        if($delete){
            $deleteDetailNote = DetailNote::where('id_note',$data['id'])->delete();
            if(($deleteDetailNote)){
                return response()->json(['res' => 'success'],200);
            }else{
                return response()->json(['res' => 'fail'],200);
            }
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $delete = Notes::where('id_note',$id)->delete();
            if($delete){
                $deleteDetailNote = DetailNote::where('id_note',$id)->delete();
                if($deleteDetailNote){
                    $noti += ['res' => 'success'];
                }else{
                    $noti += ['res' => 'fail'];
                }
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

    function randomCode($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
