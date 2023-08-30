<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitsController extends Controller
{
    function list(){
        $title = 'Danh sách đơn vị tính';
        $list = Units::all();
        return view('units.list',compact('title','list'));
    }

    function insert(Request $request){
        $data = $request->all();
        Validator::make($data,[
            'fullname_unit' => ['required', 'regex:/^[\p{L}\s\p{P}]+$/u'],
            'abbreviation_unit' => ['required', 'regex:/^[a-zA-Z-]+$/']
        ],[
            'fullname_unit.required' => 'Tên đầy đủ bắt buộc phải có',
            'fullname_unit.regex' => 'Tên đầy đủ phải là chữ cái',
            'abbreviation_unit.required' => 'Tên ký hiệu bắt buộc phải có',
            'abbreviation_unit.regex' => 'Tên ký hiệu phải là chữ cái',
        ])->validate();
        $db = [
            'fullname_unit' => $data['fullname_unit'],
            'abbreviation_unit' => $data['abbreviation_unit'],
        ];;
        $insert = Units::create($db);
        if($insert){
            return redirect()->route('units.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('units.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request){
        $data = $request->all();
        $errors = [];
        if($data['fullname_unit'] == ''){
            $errors['fullname'] = 'Tên đầy đủ bắt buộc phải có';
        }else if(!preg_match('/^[\p{L}\s\p{P}]+$/u',$data['fullname_unit'])){
            $errors['fullname'] = 'Tên đầy đủ phải là chữ cái';
        }

        if($data['abbreviation_unit'] == ''){
            $errors['abbreviation'] = 'Tên ký hiệu bắt buộc phải có';
        }else if(!preg_match('/^[a-zA-Z-]+$/',$data['abbreviation_unit'])){
            $errors['abbreviation'] = 'Tên ký hiệu phải là chữ cái';
        }
        
        if(count($errors) == 0){
            $unit = Units::find($data['id_unit']);
            $unit->fullname_unit = $data['fullname_unit'];
            $unit->abbreviation_unit = $data['abbreviation_unit'];
            $update = $unit->save();
            if($update){
                return response()->json(['res' => 'success', 'status' => 'Thay đổi dữ liệu thành đơn vị '.$data['fullname_unit'].' thành công']);
            }else{
                return response()->json(['res' => 'fail', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $errors]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Units::find($data['id'])->delete();
        if($delete){
            Ingredients::where('id_unit',$data['id'])->delete();
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $delete = Units::where('id_unit',$id)->delete();
            if($delete){
                Ingredients::where('id_unit',$id)->delete();
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
