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
        $fileName = $slug . '-' . strtotime(now()) . '.jpg';
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
        $image->storeAs('public/slide', $fileName); // se luu vao storage/app
        $db = [
            'image_slide' => 'storage/slide/'.$fileName,
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

    function update(Request $request){
        $data = $request->all();
        $image = $request->file('image_slide');
        $errors = [];
        $validator = Validator::make($data,[
            'image_slide' => ['image','mimes:jpeg,png,jpg,gif'],
            'name_slide' => ['required'],
            'slug_slide' => ['required']
        ],[
            'image_slide.image' => 'Tệp phải là hình ảnh.',
            'image_slide.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
            'name_slide.required' => 'Tên của ảnh bắt buộc phải có',
            'slug_slide.required' => 'Địa chỉ sau URL bắt buộc phải có'
        ]);
        if(!$validator->fails()){
            $slug = Str::slug($data['slug_slide'], '-');
            $fileName = $slug . '-' . strtotime(now()) . '.jpg';
            if($image){
                $checkImageOriginal = Storage::disk('public')->exists($data['image_original_slide']);
                $image->storeAs('public/slide', $fileName); // se luu vao storage/app
                // $data['image_slide']->storeAs('public', $fileName);
                if($checkImageOriginal){
                    Storage::disk('public')->delete('slide/'.$data['image_original_slide']);
                }
            }
            $slide = Slide::find($data['id_slide']);
            $slide->image_slide = $image ? 'storage/slide/'.$fileName : 'storage/slide/'.$data['image_original_slide'];
            $slide->name_slide = $data['name_slide'];
            $slide->slug_slide = $data['slug_slide'];
            $update = $slide->save();
            if($update){
                return response()->json(['res' => 'success', 'title' => 'Sửa quảng cáo', 'icon' => 'success', 'status' => 'Thay đổi dữ liệu thành quảng cáo về '.$data['name_slide'].' thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Sửa quảng cáo', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Slide::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success', 'title' => 'Xóa quảng cáo', 'icon' => 'success', 'status' => 'Xóa thành công'],200);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Sửa quảng cáo', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $delete = Slide::where('id_slide',$id)->delete();
            if($delete){
                $noti += ['res' => 'success'];
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success', 'title' => 'Xóa quảng cáo', 'icon' => 'success', 'status' => 'Xóa thành công'],200);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Sửa quảng cáo', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }
}
