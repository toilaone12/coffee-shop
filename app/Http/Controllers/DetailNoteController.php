<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\DetailNote;
use App\Models\Ingredients;
use App\Models\Notes;
use App\Models\Notification;
use App\Models\Supplier;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class DetailNoteController extends Controller
{
    //
    function list(Request $request){
        $code = $request->get('code');
        $title = 'Chi tiết phiếu hàng';
        $list = DetailNote::where('code_note',$code)->get();
        $note = Notes::where('code_note',$code)->first();
        if(count($list) != 0){
            $supplier = Supplier::find($note->id_supplier);
            $listUnit = Units::all();
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
            return view('notes.detail',compact('title','list','listUnit','note','supplier','notifications','dot'));
        }else{
            if($note){
                $note->delete();
            }
            return redirect()->route('notes.list');
        }
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
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã thêm chi tiết phiếu hàng "#'.$data['code_note'].'"',
                    'link' => redirect()->route('detail.list',['code' => $data['code_note']])->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
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

    function update(Request $request){
        $data = $request->all();
        $list = $data['formDataArray'];
        $noti = [];
        $error = [];
        $note = Notes::where('code_note',$data['code_note'])->first();
        $note->id_supplier = $data['id_supplier'];
        $note->name_note = $data['name_note'];
        $note->quantity_note = $data['quantity_note'];
        $updateNote = $note->save();
        if($updateNote){
            foreach ($list as $keyList => $one) {
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
                    $detailNote = DetailNote::where('code_note',$data['code_note'])->get();
                    // kiem tra key trong mang $detailNote
                    if (array_key_exists($keyList, $detailNote->toArray())) {
                        // Update chi tiết đã tồn tại
                        $detail = $detailNote[$keyList];
                        $detail->id_unit = $one['id_unit'];
                        $detail->name_ingredient = $one['name_ingredient'];
                        $detail->quantity_ingredient = $one['quantity_ingredient'];
                        $detail->price_ingredient = str_replace('.', '', $one['price_ingredient']);
                        $updateDetailNote = $detail->save();
                        if ($updateDetailNote) {
                            $noti += ['res' => 'success'];
                        } else {
                            $noti += ['res' => 'warning'];
                        }
                    } else {
                        // Tạo mới chi tiết chưa tồn tại
                        $db = [
                            'id_note' => $note->id_note,
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
                            $noti += ['res' => 'warning'];
                        }
                    }
                }else{
                    $noti += ['res' => 'warning'];
                }
            }
            if ($noti['res'] == 'success') {
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã sửa chi tiết phiếu hàng "#'.$data['code_note'].'"',
                    'link' => redirect()->route('detail.list',['code' => $data['code_note']])->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Sửa thành công', 'status' => 'Bạn đã sửa phiếu chi tiết thành công.'], 200);
            } else if($noti['res'] == 'fail') {
                return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Sửa thất bại', 'status' => 'Lỗi truy vấn dữ liệu']);
            } else {
                return response()->json(['res' => 'warning', 'status' => $error]);
            }
        } else {
            return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Sửa phiếu thất bại', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $detail = DetailNote::find($data['id']);
        if($detail){
            $code = $detail->code_note;
            $name = $detail->name_ingredients;
            $detail->delete();
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa nguyên liệu "'.$name.'" trong chi tiết phiếu hàng "#'.$code.'"',
                'link' => redirect()->route('detail.list',['code' => $code])->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    function deleteAll(Request $request)
    {
        $data = $request->all();
        $noti = [];
        foreach ($data['arrId'] as $key => $id) {
            $detail = DetailNote::where('id_detail',$id)->first();
            if ($detail) {
                $code = $detail->code_note;
                $name = $detail->name_ingredients;
                $detail->delete();
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã xóa nguyên liệu "'.$name.'" trong chi tiết phiếu hàng "#'.$code.'"',
                    'link' => redirect()->route('detail.list',['code' => $code])->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                $noti += ['res' => 'success'];
            } else {
                $noti += ['res' => 'fail'];
            }
        }
        if ($noti['res'] == 'success') {
            return response()->json(['res' => 'success', 'title' => 'Xóa phí vận chuyển', 'icon' => 'success', 'status' => 'Xóa thành công']);
        } else {
            return response()->json(['res' => 'fail', 'title' => 'Xóa phí vận chuyển', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    function export(Request $request){
        $id = $request->get('id');
        $list = DetailNote::where('id_note',$id)->get();
        $noti = [];
        foreach($list as $key => $one){
            $existIngredient = Ingredients::where('name_ingredient', $one->name_ingredient)->first();
            if(!$existIngredient){
                $db = [
                    'id_unit' => $one->id_unit,
                    'name_ingredient' => $one->name_ingredient,
                    'quantity_ingredient' => $one->quantity_ingredient,
                ];
                $ingredient = Ingredients::create($db);
                if($ingredient){
                    $noti += ['res' => 'success'];
                }else{
                    $noti += ['res' => 'fail'];
                }
            }else{
                if($existIngredient->id_unit === 1 && $one->id_unit == 2){
                    $one->quantity_ingredient = $this->convertUnit($one->quantity_ingredient, 'g', 'kg');
                }else if($existIngredient->id_unit === 2 && $one->id_unit == 1){
                    $one->quantity_ingredient = $this->convertUnit($one->quantity_ingredient, 'kg', 'g');
                }else if($existIngredient->id_unit === 3 && $one->id_unit == 4){
                    $one->quantity_ingredient = $this->convertUnit($one->quantity_ingredient, 'ml', 'l');
                }else if($existIngredient->id_unit === 4 && $one->id_unit == 3){
                    $one->quantity_ingredient = $this->convertUnit($one->quantity_ingredient, 'l', 'ml');
                }
                $quantityUpdate = $existIngredient->quantity_ingredient + $one->quantity_ingredient;
                $existIngredient->quantity_ingredient = $quantityUpdate;
                $update = $existIngredient->save();
                if($update){
                    $noti += ['res' => 'success'];
                }else{
                    $noti += ['res' => 'fail'];
                }
            }
        }
        if($noti['res'] == 'success'){
            $note = Notes::find($id);
            $note->status_note = 1;
            $update = $note->save();
            if($update){
                return response()->json(['res' => 'success', 'icon' => 'success', 'title'=> 'Xuất nguyên liệu', 'status' => 'Bạn đã xuất nguyên liệu thành công']);
            }else{
                return response()->json(['res' => 'fail', 'icon' => 'error', 'title'=> 'Xuất nguyên liệu', 'status' => 'Bạn đã xuất nguyên liệu thất bại']);
            }
        }
    }
    //ham quy doi
    function convertUnit($value, $fromUnit, $toUnit) {
        // Chuyển đơn vị đầu vào và đầu ra thành chữ thường để so sánh
        $fromUnit = strtolower($fromUnit);
        $toUnit = strtolower($toUnit);
    
        // Biến đổi giá trị dựa trên đơn vị đầu vào và đầu ra
        switch ("$fromUnit-$toUnit") {
            case 'kg-g':
                return $value * 1000; // 1 kg = 1000 g
            case 'g-kg':
                return $value / 1000; // 1 g = 0.001 kg
            case 'ml-l':
                return $value / 1000; // 1 ml = 0.001 l
            case 'l-ml':
                return $value * 1000; // 1 l = 1000 ml
            default:
                Log::error("Không thể chuyển đổi từ $fromUnit sang $toUnit");
                return null; // Trả về null nếu không thể chuyển đổi
        }
    }
}
