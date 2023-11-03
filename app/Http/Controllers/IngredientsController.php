<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Ingredients;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class IngredientsController extends Controller
{
    function list()
    {
        $title = 'Danh sách nguyên liệu';
        $list = Ingredients::all();
        $listUnits = Units::all();
        return view('ingredients.list', compact('title', 'list', 'listUnits'));
    }

    function update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name_ingredient' => ['required', 'regex: /^[\p{L}\s\p{P}]+$/u'],
        ], [
            'name_ingredient.required' => 'Tên nguyên liệu bắt buộc phải có',
            'name_ingredient.regex' => 'Tên nguyên liệu bắt buộc phải là chữ cái',
        ]);
        if (!$validator->fails()) {
            $existIngredient = Ingredients::where('name_ingredient', $data['name_ingredient'])->first();
            if ($existIngredient) {
                return response()->json(['res' => 'warning', 'status' => ['name_ingredient' => 'Tên nguyên liệu đã tồn tại']]);
            } else {
                $ingredient = Ingredients::find($data['id_ingredient']);
                $quantityUpdate = 0;
                if ($ingredient->id_unit === 1 && $data['id_unit'] == 2) {
                    $quantityUpdate = $this->convertUnit($ingredient->quantity_ingredient, 'kg', 'g');
                } else if ($ingredient->id_unit === 2 && $data['id_unit'] == 1) {
                    $quantityUpdate = $this->convertUnit($ingredient->quantity_ingredient, 'g', 'kg');
                } else if ($ingredient->id_unit === 3 && $data['id_unit'] == 4) {
                    $quantityUpdate = $this->convertUnit($ingredient->quantity_ingredient, 'l', 'ml');
                } else if ($ingredient->id_unit === 4 && $data['id_unit'] == 3) {
                    $quantityUpdate = $this->convertUnit($ingredient->quantity_ingredient, 'ml', 'l');
                }
                $ingredient->id_unit = $data['id_unit'];
                $ingredient->name_ingredient = $data['name_ingredient'];
                $ingredient->quantity_ingredient = $quantityUpdate ? $quantityUpdate : $ingredient->quantity_ingredient;
                $update = $ingredient->save();
                if ($update) {
                    return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Sửa nguyên liệu', 'status' => 'Bạn đã sửa nguyên liệu thành công']);
                } else {
                    return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Sửa nguyên liệu', 'status' => 'Lỗi truy vấn']);
                }
            }
        } else {
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Ingredients::find($data['id'])->delete();
        $noti = [];
        if($delete){
            $recipes = Recipe::whereJsonContains('component_recipe', [['id_ingredient' => $data['id']]])->get();
            foreach($recipes as $key => $recipe){
                $idProduct = $recipe->id_product;
                $delete = $recipe->delete();
                if($delete){
                    $product = Product::where('id_product',$idProduct)->delete();
                    $review = Review::where('id_product',$idProduct)->delete();
                    $recipe = Recipe::where('id_product',$idProduct)->delete();
                    $gallery = Gallery::where('id_product',$idProduct)->delete();
                    $noti += ['res' => 'success'];
                }
            }
            if($noti['res'] == 'success'){
                return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Xoá nguyên liệu', 'status' => 'Bạn đã xóa nguyên liệu thành công']);
            } else {
                return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Xoá nguyên liệu', 'status' => 'Lỗi truy vấn']);
            }
        } else {
            return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Xoá nguyên liệu', 'status' => 'Lỗi truy vấn']);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $delete = Ingredients::where('id_ingredient',$id)->delete();
            if($delete){
                $recipes = Recipe::whereJsonContains('component_recipe', [['id_ingredient' => $data['id']]])->get();
                foreach($recipes as $key => $recipe){
                    $idProduct = $recipe->id_product;
                    $delete = $recipe->delete();
                    if($delete){
                        $product = Product::where('id_product',$idProduct)->delete();
                        $review = Review::where('id_product',$idProduct)->delete();
                        $recipe = Recipe::where('id_product',$idProduct)->delete();
                        $gallery = Gallery::where('id_product',$idProduct)->delete();
                        $noti += ['res' => 'success'];
                    }
                }
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Xoá nguyên liệu', 'status' => 'Bạn đã xóa nguyên liệu thành công']);
        } else {
            return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Xoá nguyên liệu', 'status' => 'Lỗi truy vấn']);
        }
    }

    //ham quy doi
    function convertUnit($value, $fromUnit, $toUnit)
    {
        // Chuyển đơn vị đầu vào và đầu ra thành chữ thường để so sánh
        $fromUnit = strtolower($fromUnit);
        $toUnit = strtolower($toUnit);

        // Biến đổi giá trị dựa trên đơn vị đầu vào và đầu ra
        switch ("$fromUnit-$toUnit") {
            case 'kg-l':
                return $value; // 1 kg = 1 l
            case 'kg-g':
                return $value * 1000; // 1 kg = 1000 g
            case 'kg-ml':
                return $value * 1000; // 1 kg = 1000 g
            case 'g-ml':
                return $value; // 1 g = 1 ml
            case 'g-kg':
                return $value / 1000; // 1 g = 0.001 kg
            case 'g-l':
                return $value / 1000; // 1 g = 0.001 l
            case 'ml-g':
                return $value; // 1 ml = 1 g
            case 'ml-l':
                return $value / 1000; // 1 ml = 0.001 l
            case 'ml-kg':
                return $value / 1000; // 1 ml = 0.001 kg
            case 'l-kg':
                return $value; // 1 l = 1 kg
            case 'l-g':
                return $value * 1000; // 1 l = 1000 g
            case 'l-ml':
                return $value * 1000; // 1 l = 1000 ml
            default:
                Log::error("Không thể chuyển đổi từ $fromUnit sang $toUnit");
                return null; // Trả về null nếu không thể chuyển đổi
        }
    }
}
