<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    //
    function list(Request $request){
        $id = $request->get('id');
        $title = 'Danh sách quảng cáo';
        $list = Gallery::where('id_product',$id)->get();
        return view('gallery.list',compact('title','list','id'));
    }

    function insert(Request $request){
        $data = $request->all();
        $images = $request->file('image_gallery');
        $noti = array();
        Validator::make($data, [
            'image_gallery' => ['required', 'array'],
            'image_gallery.*' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,gif'],
        ], [
            'image_gallery.required' => 'Vui lòng chọn ít nhất một tệp ảnh.',
            'image_gallery.*.required' => 'Vui lòng chọn một tệp ảnh.',
            'image_gallery.*.file' => 'Không thể xử lý tệp đã chọn.',
            'image_gallery.*.image' => 'Tệp phải là hình ảnh.',
            'image_gallery.*.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
        ])->validate();
        foreach($images as $key => $one){
            $image = current(explode('.',$one->getClientOriginalName())); // lay ra phan tu dau tien cua mang
            $slug = Str::slug($image, '-');
            $fileName = $slug . '-' . strtotime(now()) . '.jpg';
            $one->storeAs('public/gallery', $fileName); // se luu vao storage/app
            $db = [
                'id_product' => $data['id_product'],
                'image_gallery' => 'storage/gallery/'.$fileName,
            ];
            $insert = Gallery::create($db);
            if($insert){
                $noti += ['res' => 'success'];
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] === 'success'){
            return redirect()->route('gallery.list?id='.$data['id_product'])->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('gallery.list?id='.$data['id_product'])->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request){
        $data = $request->all();
        dd($data);
        $image = $request->file('image_slide');
        $errors = [];
        $validator = Validator::make($data,[
            'image_slide' => ['required','image','mimes:jpeg,png,jpg,gif'],
            'name_slide' => ['required'],
            'slug_slide' => ['required']
        ],[
            'image_slide.required' => 'Vui lòng chọn một tệp ảnh.',
            'image_slide.image' => 'Tệp phải là hình ảnh.',
            'image_slide.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
            'name_slide.required' => 'Tên của ảnh bắt buộc phải có',
            'slug_slide.required' => 'Địa chỉ sau URL bắt buộc phải có'
        ]);
        if(!$validator->fails()){
            $slug = Str::slug($data['slug_slide'], '-');
            $fileName = $slug . '-' . strtotime(now()) . '.jpg';
            $checkImageOriginal = Storage::disk('public')->exists($data['image_original_slide']);
            $image->storeAs('public', $fileName); // se luu vao storage/app
            // $data['image_slide']->storeAs('public', $fileName);
            if($checkImageOriginal){
                Storage::disk('public')->delete($data['image_original_slide']);
            }
            $slide = Slide::find($data['id_slide']);
            $slide->image_slide = 'storage/'.$fileName;
            $slide->name_slide = $data['name_slide'];
            $slide->slug_slide = $data['slug_slide'];
            $update = $slide->save();
            if($update){
                return response()->json(['res' => 'success', 'status' => 'Thay đổi dữ liệu thành quảng cáo về '.$data['name_slide'].' thành công']);
            }else{
                return response()->json(['res' => 'fail', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    // function delete(Request $request){
    //     $data = $request->all();
    //     $delete = Slide::find($data['id'])->delete();
    //     if($delete){
    //         return response()->json(['res' => 'success'],200);
    //     }else{
    //         return response()->json(['res' => 'fail'],200);
    //     }
    // }

}
