<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    //
    function list(Request $request){
        $id = $request->get('id');
        $title = 'Danh sách quảng cáo';
        $list = Gallery::where('id_product',$id)->get();
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
        return view('gallery.list',compact('title','list','id','notifications','dot'));
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
            return redirect()->route('gallery.list',["id" => $data["id_product"]])->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('gallery.list',["id" => $data["id_product"]])->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request){
        $data = $request->all();
        $image = $request->file('image_gallery');
        $nameImage = current(explode('.',$image->getClientOriginalName())); // lay ra phan tu dau tien cua mang
        $slug = Str::slug($nameImage, '-');
        $fileName = $slug . '-' . strtotime(now()) . '.jpg';
        $validator = Validator::make($data,[
            'image_gallery' => ['mimes:jpeg,png,jpg,gif'],
        ],[
            'image_gallery.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
        ]);
        if(!$validator->fails()){
            $pathStorage = 'storage/gallery/';
            if($image){
                $checkImageOriginal = Storage::disk('public')->exists('gallery/'.$data['image_original_gallery']);
                // dd($checkImageOriginal);
                $image->storeAs('public/gallery', $fileName); // se luu vao storage/app
                if($checkImageOriginal){
                    Storage::disk('public')->delete('gallery/'.$data['image_original_gallery']);
                }
            }
            $gallery = Gallery::find($data['id_gallery']);
            $gallery->image_gallery = $image ? $pathStorage.$fileName : $pathStorage.$data['image_original_gallery'];
            $update = $gallery->save();
            if($update){
                return response()->json(['res' => 'success', 'title' => 'Danh mục ảnh sản phẩm', 'icon' => 'success', 'status' => 'Thay đổi dữ liệu danh mục ảnh thành công'], 200);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Danh mục ảnh sản phẩm', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu'], 200);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Gallery::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success', 'title' => 'Danh mục ảnh sản phẩm', 'icon' => 'success', 'status' => 'Xóa danh mục ảnh thành công'], 200);
        } else {
            return response()->json(['res' => 'fail', 'title' => 'Danh mục ảnh sản phẩm', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu'], 200);
        }
    }

    function deleteAll(Request $request)
    {
        $data = $request->all();
        $noti = [];
        // dd($data);
        foreach ($data['arrId'] as $key => $id) {
            $gallery = Gallery::where('id_gallery', $id)->first();
            if ($gallery) {
                $gallery->delete();
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã xóa danh mục ảnh',
                    'link' => redirect()->route('gallery.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                $noti += ['res' => 'success'];
            } else {
                $noti += ['res' => 'fail'];
            }
        }
        if ($noti['res'] == 'success') {
            return response()->json(['res' => 'success', 'title' => 'Danh mục ảnh sản phẩm', 'icon' => 'success', 'status' => 'Xóa danh mục ảnh thành công'], 200);
        } else {
            return response()->json(['res' => 'fail', 'title' => 'Danh mục ảnh sản phẩm', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu'], 200);
        }
    }

}
