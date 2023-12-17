<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    function check(Request $request){
        $id = $request->get('id');
        $recipe = Recipe::find($id);
        $components = json_decode($recipe->component_recipe);
        $product = Product::find($recipe->id_product);
        $arrIngredients = [];
        foreach ($components as $key => $one) {
            $unitComponent = Units::find(intval($one->id_unit)); // tim don vi cua thanh phan trong cong thuc
            $ingredient = Ingredients::find(intval($one->id_ingredient)); //tim nguyen lieu trong ds nguyen lieu
            $unitIngredient = Units::find(intval($ingredient->id_unit)); //tim don vi cua nguyen lieu
            $abbreviationComponent = $unitComponent->abbreviation_unit; //ky hieu don vi cua thanh phan trong cong thuc
            $abbreviationIngredient = $unitIngredient->abbreviation_unit; //ky hieu don vi cua nguyen lieu
            $quantityIngredient = floatval($ingredient->quantity_ingredient); //so luong nguyen lieu
            $quantityComponent = intval($one->quantity_recipe_need); // so luong cua thanh phan trong nguyen lieu
            $totalProduct = 0;
            $quantityComponentConvert = 0;
            if ($abbreviationComponent == $abbreviationIngredient) { //ktra 2 don vi giong nhau k 
                $quantityComponentConvert = $quantityComponent;
            } else {
                $quantityComponentConvert = $this->convertUnit($quantityComponent, $abbreviationComponent, $abbreviationIngredient);
            }
            $totalProduct = intval($quantityIngredient / $quantityComponentConvert);
            $arrIngredients[] = $totalProduct;
        }
        // dd($arrIngredients); 
        $status = 'Số lượng bạn có thể làm ra sản phẩm '.$product->name_product.' ít nhất là '.min($arrIngredients).' sản phẩm';
        return response()->json(['res' => 'success', 'title' => 'Thông báo số lượng có thể làm ra', 'icon' => 'success', 'status' => $status]);
    }

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
