<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    function list(){
        $title = 'Danh sách danh mục';
        $list = Category::all();
        $listParent = Category::where('id_parent_category',0)->get();
        return view('category.list',compact('title','list','listParent'));
    }

    function insert(Request $request){
        $data = $request->all();
        Validator::make($data,[
            'name_category' => ['required', 'regex:/^[\p{L}\s\p{P}]+$/u'],
        ],[
            'name_category.required' => 'Tên danh mục bắt buộc phải có',
            'name_category.regex' => 'Tên danh mục phải là chữ cái',
        ])->validate();
        $db = [
            'name_category' => $data['name_category'],
            'id_parent_category' => $data['id_parent_category'],
        ];
        $insert = Category::create($db);
        if($insert){
            return redirect()->route('category.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('category.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request){
        $data = $request->all();
        $errors = [];
        if($data['name_category'] == ''){
            $errors['name'] = 'Tên danh mục bắt buộc phải có';
        }else if(!preg_match('/^[\p{L}\s\p{P}]+$/u',$data['name_category'])){
            $errors['name'] = 'Tên danh mục phải là chữ cái';
        }
        if(count($errors) == 0){
            $category = Category::find($data['id_category']);
            $category->name_category = $data['name_category'];
            $category->id_parent_category = $data['id_parent_category'];
            $update = $category->save();
            if($update){
                return response()->json(['res' => 'success', 'status' => 'Thay đổi dữ liệu thành danh mục '.$data['name_category'].' thành công']);
            }else{
                return response()->json(['res' => 'fail', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $errors]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Category::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }
}
