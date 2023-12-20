<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Ingredients;
use App\Models\Notification;
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
        return view('ingredients.list', compact('title', 'list', 'listUnits','notifications','dot'));
    }

    function update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name_ingredient' => ['required', 'regex: /^[\p{L}\s\p{P}]+$/u'],
            'quantity_ingredient' => ['required'],
        ], [
            'name_ingredient.required' => 'Tên nguyên liệu bắt buộc phải có',
            'name_ingredient.regex' => 'Tên nguyên liệu bắt buộc phải là chữ cái',
            'quantity_ingredient.required' => 'Số lượng nguyên liệu bắt buộc phải có',
        ]);
        if (!$validator->fails()) {
            $ingredient = Ingredients::find($data['id_ingredient']);
            $unitOld = Units::find($ingredient->id_unit);
            $unitNew = Units::find($data['id_unit']);
            $abbreviationOld = $unitOld->abbreviation_unit;
            $abbreviationNew = $unitNew->abbreviation_unit;
            $quantityUpdate = $this->convertUnit(doubleval($data['quantity_ingredient']), $abbreviationOld, $abbreviationNew);
            if($quantityUpdate){
                $ingredient->id_unit = $data['id_unit'];
                $ingredient->name_ingredient = $data['name_ingredient'];
                $ingredient->quantity_ingredient = $quantityUpdate;
                $update = $ingredient->save();
                if ($update) {
                    $noti = [
                        'id_account' => request()->cookie('id_account'),
                        'id_customer' => 0,
                        'content' => 'Bạn đã cập nhật nguyên liệu "'.$data['name_ingredient'].'"',
                        'link' => redirect()->route('ingredients.list')->getTargetUrl(),
                        'is_read' => 0,
                    ];
                    Notification::create($noti);
                    return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Sửa nguyên liệu', 'status' => 'Bạn đã sửa nguyên liệu thành công']);
                } else {
                    return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Sửa nguyên liệu', 'status' => 'Lỗi truy vấn']);
                }
            }else{
                return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Sửa nguyên liệu', 'status' => 'Không thể quy đổi đơn vị từ '.$unitNew->fullname_unit.' sang '.$unitOld->fullname_unit]);
            }
        } else {
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $ingredient = Ingredients::find($data['id']);
        $noti = [];
        if($ingredient){
            $name = $ingredient->name_ingredient;
            $ingredient->delete();
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa nguyên liệu "'.$name.'"',
                'link' => redirect()->route('ingredients.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            $recipes = Recipe::whereJsonContains('component_recipe', [['id_ingredient' => $data['id']]])->get();
            if($recipes){
                foreach($recipes as $key => $recipe){
                    $idProduct = $recipe->id_product;
                    $delete = $recipe->delete();
                    if($delete){
                        $product = Product::where('id_product',$idProduct)->delete();
                        $review = Review::where('id_product',$idProduct)->delete();
                        $recipe = Recipe::where('id_product',$idProduct)->delete();
                        $gallery = Gallery::where('id_product',$idProduct)->delete();
                    }
                    $noti += ['res' => 'success'];
                }
            }
            return response()->json(['res' => 'success', 'icon' => 'success', 'title' => 'Xoá nguyên liệu', 'status' => 'Bạn đã xóa nguyên liệu thành công']);
        } else {
            return response()->json(['res' => 'fail', 'icon' => 'error', 'title' => 'Xoá nguyên liệu', 'status' => 'Lỗi truy vấn']);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        // dd($data['arrId'] );
        foreach($data['arrId'] as $key => $id){
            $ingredient = Ingredients::where('id_ingredient',$id)->first();
            if($ingredient){
                $name = $ingredient->name_ingredient;
                $ingredient->delete();
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã xóa nguyên liệu "'.$name.'"',
                    'link' => redirect()->route('ingredients.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                $recipes = Recipe::whereJsonContains('component_recipe', [['id_ingredient' => "$ingredient->id_ingredient"]])->get();
                if($recipes){
                    foreach($recipes as $key => $recipe){
                        // dd($recipes);
                        $idProduct = $recipe->id_product;
                        $delete = $recipe->delete();
                        if($delete){
                            $product = Product::where('id_product',$idProduct)->delete();
                            $review = Review::where('id_product',$idProduct)->delete();
                            $recipe = Recipe::where('id_product',$idProduct)->delete();
                            $gallery = Gallery::where('id_product',$idProduct)->delete();
                        }
                    }
                }
                $noti += ['res' => 'success'];
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
            case 'kg-kg':
                return $value; // 1 l = 1 kg
            case 'g-g':
                return $value; // 1 l = 1 kg
            case 'ml-ml':
                return $value; // 1 l = 1 kg
            case 'l-l':
                return $value; // 1 l = 1 kg
            case 'c-c':
                return $value; // 1 l = 1 kg
            default:
                return false; // Trả về null nếu không thể chuyển đổi
        }
    }
}
