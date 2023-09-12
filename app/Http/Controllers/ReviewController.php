<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    //
    function list(){
        $title = 'Danh sách đánh giá';
        $list = Review::all();
        $listProduct = Product::all();
        return view('review.list',compact('title','list','listProduct'));
    }

    function reply(Request $request){
        $data = $request->all();
        Validator::make($data,[
            'title_reply' => ['required']
        ],[
            'title_reply.required' => 'Nội dung phản hồi khách hàng bắt buộc phải có'
        ])->validate();
        $review = Review::find($data['id_reply']);
        if($review){
            $review->is_update = 2;
            $update = $review->save();
            if($update){
                $db = [
                    'id_product' => intval($review->id_product),
                    'name_review' => 'Quản trị viên',
                    'content_review' => $data['title_reply'],
                    'rating_review' => 0,
                    'id_reply' => $data['id_reply'],
                    'is_update' => 1,
                ];
                $insert = Review::create($db);
                if($insert){
                    return redirect()->route('review.list')->with('success','Phản hồi thành công');
                }else{
                    return redirect()->route('review.list')->with('error','Phản hồi thất bại');
                }
            }
        }
    }

    function update(Request $request){
        $data = $request->all();
        dd($data);
        $validation = Validator::make($data,[
            'title_reply' => ['required']
        ],[
            'title_reply.required' => 'Nội dung phản hồi khách hàng bắt buộc phải có'
        ]);
        if(!$validation->fails()){
            $review = Review::find($data['id_review']);
            $review->content_review = $data['title_reply'];
            $update = $review->save();
            if($update){
                return response()->json(['res' => 'success', 'title' => 'Sửa phản hồi', 'icon' => 'success', 'status' => 'Sửa phản hồi thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Sửa phản hồi', 'icon' => 'error', 'status' => 'Lỗi truy vấn']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }
}
