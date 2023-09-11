<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class NewsController extends Controller
{
    //
    function list(){
        $title = 'Danh sách tin tức';
        $list = News::all();
        return view('news.list',compact('title','list'));
    }

    function insert(Request $request){
        $data = $request->all();
        $image = $request->file('image_new');
        $slug = Str::slug($data['name_new'], '-');
        $fileName = $slug . '-' . strtotime(now()) . '.jpg';
        Validator::make($data,[
            'image_new' => ['required','image','mimes:jpeg,png,jpg,gif'],
            'name_new' => ['required'],
            'content_new' => ['required'],
        ],[
            'image_new.required' => 'Vui lòng chọn một tệp ảnh.',
            'image_new.image' => 'Tệp phải là hình ảnh.',
            'image_new.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
            'name_new.required' => 'Tiêu đề bắt buộc phải có',
            'content_new.required' => 'Nội dung bắt buộc phải có'
        ])->validate();
        $image->storeAs('public/news', $fileName); // se luu vao storage/app
        $db = [
            'image_new' => 'storage/news/'.$fileName,
            'title_new' => $data['name_new'],
            'subtitle_new' => $data['subtitle_new'],
            'content_new' => $data['content_new'],
            'view_new' => 0
        ];
        $insert = News::create($db);
        if($insert){
            return redirect()->route('news.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('news.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    // function update(Request $request){
    //     $data = $request->all();
    //     $image = $request->file('image_slide');
    //     $errors = [];
    //     $validator = Validator::make($data,[
    //         'image_slide' => ['required','image','mimes:jpeg,png,jpg,gif'],
    //         'name_slide' => ['required'],
    //         'slug_slide' => ['required']
    //     ],[
    //         'image_slide.required' => 'Vui lòng chọn một tệp ảnh.',
    //         'image_slide.image' => 'Tệp phải là hình ảnh.',
    //         'image_slide.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
    //         'name_slide.required' => 'Tên của ảnh bắt buộc phải có',
    //         'slug_slide.required' => 'Địa chỉ sau URL bắt buộc phải có'
    //     ]);
    //     if(!$validator->fails()){
    //         $slug = Str::slug($data['slug_slide'], '-');
    //         $fileName = $slug . '-' . strtotime(now()) . '.jpg';
    //         $checkImageOriginal = Storage::disk('public')->exists($data['image_original_slide']);
    //         $image->storeAs('public', $fileName); // se luu vao storage/app
    //         // $data['image_slide']->storeAs('public', $fileName);
    //         if($checkImageOriginal){
    //             Storage::disk('public')->delete($data['image_original_slide']);
    //         }
    //         $slide = Slide::find($data['id_slide']);
    //         $slide->image_slide = 'storage/'.$fileName;
    //         $slide->name_slide = $data['name_slide'];
    //         $slide->slug_slide = $data['slug_slide'];
    //         $update = $slide->save();
    //         if($update){
    //             return response()->json(['res' => 'success', 'status' => 'Thay đổi dữ liệu thành quảng cáo về '.$data['name_slide'].' thành công']);
    //         }else{
    //             return response()->json(['res' => 'fail', 'status' => 'Lỗi truy vấn dữ liệu']);
    //         }
    //     }else{
    //         return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
    //     }
    // }

    // function delete(Request $request){
    //     $data = $request->all();
    //     $delete = Slide::find($data['id'])->delete();
    //     if($delete){
    //         return response()->json(['res' => 'success'],200);
    //     }else{
    //         return response()->json(['res' => 'fail'],200);
    //     }
    // }

    // function deleteAll(Request $request){
    //     $data = $request->all();
    //     $noti = [];
    //     foreach($data['arrId'] as $key => $id){
    //         $delete = Slide::where('id_slide',$id)->delete();
    //         if($delete){
    //             $noti += ['res' => 'success'];
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
}
