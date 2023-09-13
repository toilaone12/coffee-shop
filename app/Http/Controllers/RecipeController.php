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
        $listUnits = Units::where('id_unit','!=',1)->where('id_unit','!=',3)->get();
        return view('recipe.list',compact('title','list','listProduct','listIngredients','listUnits'));
    }

    function insert(Request $request){
        $data = $request->all();
        $existRecipe = Recipe::where('id_product',$data['id_product'])->first();
        if(!$existRecipe){
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
        }else{
            return response()->json(['res' => 'warning', 'title' => 'Thêm công thức', 'icon' => 'warning', 'status' => 'Đã tồn tại sản phẩm này']);
        }
    }

    function update(Request $request){
        $data = $request->all();
        // dd($data);
        $recipe = Recipe::find($data['id_recipe']);
        $recipe->id_product = $data['id_product'];
        $recipe->component_recipe = $data['objComponent'];
        $update = $recipe->save();
        if($update){
            return response()->json(['res' => 'success', 'title' => 'Sửa công thức', 'icon' => 'success', 'status' => 'Sửa công thức thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Sửa công thức', 'icon' => 'error', 'status' => 'Sửa công thức thất bại']);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Recipe::find($data['id'])->delete();
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
            $delete = Recipe::where('id_recipe',$id)->delete();
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
}
