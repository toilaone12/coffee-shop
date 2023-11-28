<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\Notification;
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
        return view('recipe.list',compact('title','list','listProduct','listIngredients','listUnits','notifications','dot'));
    }

    function insert(Request $request){
        $data = $request->all();
        $existRecipe = Recipe::where('id_product',$data['id_product'])->first();
        $product = Product::find($data['id_product']);
        if(!$existRecipe){
            $db = [
                'id_product' => $data['id_product'],
                'component_recipe' => json_encode($data['objComponent']),
            ];
            $insert = Recipe::create($db);
            if($insert){
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã thêm công thức sản phẩm "'.$product->name_product.'"',
                    'link' => redirect()->route('recipe.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
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
        $product = Product::find($data['id_product']);
        $recipe = Recipe::find($data['id_recipe']);
        $recipe->id_product = $data['id_product'];
        $recipe->component_recipe = $data['objComponent'];
        $update = $recipe->save();
        if($update){
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã cập nhật lại công thức sản phẩm "'.$product->name_product.'"',
                'link' => redirect()->route('recipe.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return response()->json(['res' => 'success', 'title' => 'Sửa công thức', 'icon' => 'success', 'status' => 'Sửa công thức thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Sửa công thức', 'icon' => 'error', 'status' => 'Sửa công thức thất bại']);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $recipe = Recipe::find($data['id']);
        if($recipe){
            $product = Product::find($recipe->id_product);
            $name = $product->name_product;
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa công thức cho sản phẩm "'.$name.'"',
                'link' => redirect()->route('recipe.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return response()->json(['res' => 'success', 'title' => 'Xóa công thức', 'icon' => 'success', 'status' => 'Xóa công thức thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xóa công thức', 'icon' => 'error', 'status' => 'Xóa công thức thất bại']);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $recipe = Recipe::where('id_recipe',$id)->first();
            if($recipe){
                $product = Product::find($recipe->id_product);
                $name = $product->name_product;
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã xóa công thức cho sản phẩm "'.$name.'"',
                    'link' => redirect()->route('recipe.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                $noti += ['res' => 'success'];
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success', 'title' => 'Xóa công thức', 'icon' => 'success', 'status' => 'Xóa công thức thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xóa công thức', 'icon' => 'error', 'status' => 'Xóa công thức thất bại']);
        }
    }
}
