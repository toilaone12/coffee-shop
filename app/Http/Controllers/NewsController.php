<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class NewsController extends Controller
{
    //admin
    function list(){
        $title = 'Danh sách tin tức';
        $list = News::all();
        return view('news.list',compact('title','list'));
    }

    function insert(Request $request){
        $data = $request->all();
        $image = $request->file('image_new');
        $slug = Str::slug($data['title_new'], '-');
        $fileName = $slug . '-' . strtotime(now()) . '.jpg';
        Validator::make($data,[
            'image_new' => ['required','image','mimes:jpeg,png,jpg,gif'],
            'title_new' => ['required'],
            'content_new' => ['required'],
        ],[
            'image_new.required' => 'Vui lòng chọn một tệp ảnh.',
            'image_new.image' => 'Tệp phải là hình ảnh.',
            'image_new.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
            'title_new.required' => 'Tiêu đề bắt buộc phải có',
            'content_new.required' => 'Nội dung bắt buộc phải có'
        ])->validate();
        $image->storeAs('public/news', $fileName); // se luu vao storage/app
        $db = [
            'image_new' => 'storage/news/'.$fileName,
            'title_new' => $data['title_new'],
            'slug_new' => $slug,
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

    function update(Request $request){
        $data = $request->all();
        $image = $request->file('image_new');
        $validator =  Validator::make($data,[
            'image_new' => ['image','mimes:jpeg,png,jpg,gif'],
            'title_new' => ['required'],
            'content_new' => ['required'],
        ],[
            'image_new.image' => 'Tệp phải là hình ảnh.',
            'image_new.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
            'title_new.required' => 'Tiêu đề bắt buộc phải có',
            'content_new.required' => 'Nội dung bắt buộc phải có'
        ]);
        if(!$validator->fails()){
            $slug = Str::slug($data['title_new'], '-');
            $fileName = $slug . '-' . strtotime(now()) . '.jpg';
            if($image){
                $checkImageOriginal = Storage::disk('public')->exists($data['image_original_new']);
                $image->storeAs('public/news', $fileName); // se luu vao storage/app
                // $data['image_slide']->storeAs('public', $fileName);
                if($checkImageOriginal){
                    Storage::disk('public')->delete('news/'.$data['image_original_new']);
                }
            }
            $new = News::find($data['id_new']);
            $new->image_new = $image ? 'storage/news/'.$fileName : 'storage/news/'.$data['image_original_new'];
            $new->title_new = $data['title_new'];
            $new->subtitle_new = $data['subtitle_new'];
            $new->content_new = $data['content_new'];
            $new->slug_new = $slug;
            $update = $new->save();
            if($update){
                return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Sửa tin tức', 'status' => 'Thay đổi dữ liệu thành tin tức thành công']);
            }else{
                return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Sửa tin tức', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = News::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $delete = News::where('id_new',$id)->delete();
            if($delete){
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
    //page 
    function detail($slug, $id){
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        $one = News::find($id);
        $title = $one->title_new;
        return view('news.detail',compact('one','title','parentCategorys','childCategorys'));
    }
}
