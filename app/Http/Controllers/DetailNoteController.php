<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\DetailNote;
use App\Models\Ingredients;
use App\Models\Notes;
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
        $delete = DetailNote::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    function printPDF(Request $request){
        $id = $request->get('id');
        $list = DetailNote::join('units as u','u.id_unit','detail_notes.id_unit')->where('id_note',$id)->get();
        $note = Notes::where('id_note',$id)->first();
        $supplier = Supplier::where('id_supplier',$note->id_supplier)->first();
        $fullname = Cookie::get('fullname');
        $pdf = Pdf::loadView('notes.pdf',compact('supplier','note','list','fullname'))
        ->setPaper('A4')
        ->setOptions(['fontMetrics' => ['sans-serif' => 'DejaVu Sans']]);
        return $pdf->download('Mã phiếu: '.$note->code_note.'.pdf');
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
