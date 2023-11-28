<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\News;
use App\Models\Notification;
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
        return view('news.list',compact('title','list','notifications','dot'));
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
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã thêm tin tức "'.$data['title_new'].'"',
                'link' => redirect()->route('news.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
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
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã cập nhật lại tin tức "'.$data['title_new'].'"',
                    'link' => redirect()->route('news.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
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
        $news = News::find($data['id']);
        if($news){
            $title = $news->title_new;
            $news->delete();
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa tin tức "'.$title.'"',
                'link' => redirect()->route('news.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return response()->json(['res' => 'success', 'title' => 'Xóa tin tức', 'icon' => 'success', 'status' => 'Xóa thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xóa tin tức', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $news = News::where('id_new',$id)->first();
            if($news){
                $title = $news->title_new;
                $news->delete();
                $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa tin tức "'.$title.'"',
                'link' => redirect()->route('news.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
                $noti += ['res' => 'success'];
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success', 'title' => 'Xóa tin tức', 'icon' => 'success', 'status' => 'Xóa thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xóa tin tức', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }
    //page 
    function home(){
        $title = 'Tin tức';
        $lists = News::paginate(3);
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        $carts = array();
        if(request()->cookie('id_customer')){
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
        }
        return view('news.home',compact('lists','title','parentCategorys','childCategorys','carts'));
    }
    
    function detail($slug){
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        $one = News::where('slug_new',$slug)->first();
        $title = $one->title_new;
        return view('news.detail',compact('one','title','parentCategorys','childCategorys'));
    }
}
