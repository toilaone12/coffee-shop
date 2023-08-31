<?php

namespace App\Http\Controllers;

use App\Models\DetailNote;
use App\Models\Notes;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailNoteController extends Controller
{
    //
    function list(){
        $title = 'Chi tiết phiếu hàng';
        $list = DetailNote::all();
        $listUnit = Units::all();
        return view('notes.detail',compact('title','list','listUnit'));
    }
    
    function insert(Request $request)
    {
        $data = $request->all();
        $list = $data['formDataArray'];
        $noti = [];
        $error = [];
        $db = [
            'id_supplier' => $data['id_supplier'],
            'code_note' => $data['code_note'],
            'name_note' => $data['name_note'],
            'quantity_note' => $data['quantity_note'],
            'status_note' => 0
        ];
        $insert = Notes::create($db);
        if($insert){
            foreach ($list as $key => $one) {
                if ($one['name_ingredient'] == '') {
                    $error['name'] = 'Tên nguyên liệu bắt buộc phải điền vào';
                } else if (!preg_match('/^[\p{L}\s\p{P}]+$/u', $one['name_ingredient'])) {
                    $error['name'] = 'Tên nguyên liệu bắt buộc phải là chữ cái';
                }
                if ($one['price_ingredient'] == '') {
                    $error['price'] = 'Giá thành bắt buộc phải điền vào';
                }
                if ($one['quantity_ingredient'] == '') {
                    $error['quantity'] = 'Số lượng liệu bắt buộc phải điền vào';
                }
                if (count($error) == 0) {
                    $db = [
                        'id_note' => $insert->id_note,
                        'code_note' => $data['code_note'],
                        'id_unit' => $one['id_unit'],
                        'name_ingredient' => $one['name_ingredient'],
                        'quantity_ingredient' => $one['quantity_ingredient'],
                        'price_ingredient' => str_replace('.', '', $one['price_ingredient']),
                    ];
                    $insert = DetailNote::create($db);
                    if ($insert) {
                        $noti += ['res' => 'success'];
                    } else {
                        $noti += ['res' => 'fail'];
                    }
                }else{
                    $noti += ['res' => 'warning'];
                }
            }
            if ($noti['res'] == 'success') {
                return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Thêm thành công', 'status' => 'Bạn đã thêm phiếu chi tiết thành công.'], 200);
            } else if($noti['res'] == 'fail') {
                return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Thêm thất bại', 'status' => 'Lỗi truy vấn dữ liệu']);
            } else {
                return response()->json(['res' => 'warning', 'status' => $error]);
            }
        } else {
            return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Thêm thất bại', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }
}
