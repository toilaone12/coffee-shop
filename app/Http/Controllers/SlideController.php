<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SlideController extends Controller
{
    function list(){
        $title = 'Danh sách quảng cáo';
        $list = Slide::all();
        return view('slide.list',compact('title','list'));
    }

    function insert(Request $request){
        $data = $request->all();
        $image = $request->file('image_slide');
        $slug = Str::slug($data['slug_slide'], '-');
        $fileName = Str::slug($this->removeAccents($slug), '') . '-' . strtotime(now()) . '.jpg';
        Validator::make($data,[
            'image_slide' => ['required','image','mimes:jpeg,png,jpg,gif'],
            'name_slide' => ['required'],
            'slug_slide' => ['required']
        ],[
            'image_slide.required' => 'Vui lòng chọn một tệp ảnh.',
            'image_slide.image' => 'Tệp phải là hình ảnh.',
            'image_slide.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
            'name_slide.required' => 'Tên của ảnh bắt buộc phải có',
            'slug_slide.required' => 'Địa chỉ sau URL bắt buộc phải có'
        ])->validate();
        $image->storeAs('public', $fileName); // se luu vao storage/app
        $db = [
            'image_slide' => 'storage/'.$fileName,
            'name_slide' => $data['name_slide'],
            'slug_slide' => $slug,
        ];
        $insert = Slide::create($db);
        if($insert){
            return redirect()->route('slide.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('slide.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    // function update(Request $request){
    //     $data = $request->all();
    //     $errors = [];
    //     if($data['name_supplier'] == ''){
    //         $errors['name'] = 'Tên nhà cung cấp bắt buộc phải có';
    //     }
    //     if($data['phone_supplier'] == ''){
    //         $errors['phone'] = 'Số điện thoại nhà cung cấp bắt buộc phải có';
    //     }else if(!preg_match('/^(03[2-9]|05[6-9]|07[06-9]|08[1-9]|09[0-9]|01[2-9])[0-9]{7}$/',$data['phone_supplier'])){
    //         $errors['phone'] = 'Số điện thoại phải đủ 10 số và nằm trong quốc gia Việt Nam';
    //     }
    //     if($data['address_supplier'] == ''){
    //         $errors['address'] = 'Địa chỉ nhà cung cấp bắt buộc phải có';
    //     }
    //     if(count($errors) == 0){
    //         $supplier = Supplier::find($data['id_supplier']);
    //         $supplier->name_supplier = $data['name_supplier'];
    //         $supplier->phone_supplier = $data['phone_supplier'];
    //         $supplier->address_supplier = $data['address_supplier'];
    //         $update = $supplier->save();
    //         if($update){
    //             return response()->json(['res' => 'success', 'status' => 'Thay đổi dữ liệu thành nhà cung cấp '.$data['name_supplier'].' thành công']);
    //         }else{
    //             return response()->json(['res' => 'fail', 'status' => 'Lỗi truy vấn dữ liệu']);
    //         }
    //     }else{
    //         return response()->json(['res' => 'warning', 'status' => $errors]);
    //     }
    // }

    function delete(Request $request){
        $data = $request->all();
        $delete = Slide::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

}
