<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Units;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    function list(){
        $title = 'Danh sách công thức';
        $list = Recipe::all();
        $listProduct = Product::all();
        $listIngredients = Ingredients::all();
        $listUnits = Units::all();
        return view('recipe.list',compact('title','list','listProduct','listIngredients','listUnits'));
    }

    function insert(Request $request){
        $data = $request->all();
        $db = [
            'id_product' => $data['id_product'],
            'component_recipe' => json_encode($data['objComponent']),
        ];
        $insert = Recipe::create($db);
        if($insert){
            return response()->json(['res' => 'success', 'title' => 'Thêm công thức', 'icon' => 'success', 'status' => 'Thêm công thức thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Thêm công thức', 'icon' => 'error', 'status' => 'Thêm công thức thất bại']);
        }
    }

    // function update(Request $request){
    //     $data = $request->all();
    //     $errors = [];
    //     if($data['name_category'] == ''){
    //         $errors['name'] = 'Tên danh mục bắt buộc phải có';
    //     }else if(!preg_match('/^[\p{L}\s\p{P}]+$/u',$data['name_category'])){
    //         $errors['name'] = 'Tên danh mục phải là chữ cái';
    //     }
    //     if(count($errors) == 0){
    //         $category = Category::find($data['id_category']);
    //         $category->name_category = $data['name_category'];
    //         $category->id_parent_category = $data['id_parent_category'];
    //         $update = $category->save();
    //         if($update){
    //             return response()->json(['res' => 'success', 'status' => 'Thay đổi dữ liệu thành danh mục '.$data['name_category'].' thành công']);
    //         }else{
    //             return response()->json(['res' => 'fail', 'status' => 'Lỗi truy vấn dữ liệu']);
    //         }
    //     }else{
    //         return response()->json(['res' => 'warning', 'status' => $errors]);
    //     }
    // }

    // function delete(Request $request){
    //     $data = $request->all();
    //     $delete = Category::find($data['id'])->delete();
    //     if($delete){
    //         return response()->json(['res' => 'success'],200);
    //     }else{
    //         return response()->json(['res' => 'fail'],200);
    //     }
    // }
}
