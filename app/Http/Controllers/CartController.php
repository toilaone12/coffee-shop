<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //page
    function insert(Request $request){
        $data = $request->all();
        $quantity = intval($data['quantity']); // so luong them
        $product = Product::find($data['id']);
        $recipe = Recipe::where('id_product',$data['id'])->first();
        $components = json_decode($recipe->component_recipe);
        $noti = [];
        foreach($components as $key => $one){
            $unitComponent = Units::find(intval($one->id_unit)); // tim don vi cua thanh phan trong cong thuc
            $ingredient = Ingredients::find(intval($one->id_ingredient));
            $unitIngredient = Units::find(intval($ingredient->id_unit));//tim don vi cua nguyen lieu
            $abbreviationComponent = $unitComponent->abbreviation_unit; //ky hieu don vi cua thanh phan trong cong thuc
            $abbreviationIngredient = $unitIngredient->abbreviation_unit; //ky hieu don vi cua nguyen lieu
            $quantityIngredient = intval($ingredient->quantity_ingredient); //so luong nguyen lieu
            $quantityComponent = intval($one->quantity_recipe_need); // so luong cua thanh phan trong nguyen lieu
            $totalProduct = 0;
            $enoughProduct = 0;
            if($abbreviationComponent == $abbreviationIngredient){ //ktra 2 don vi giong nhau k 
                $totalProduct = $quantityComponent * $quantity; // tong so luong hien tai
                $enoughProduct = intval($quantityIngredient / $quantityComponent);
            }else{
                $quantityComponentConvert = $this->convertUnit($quantityComponent,$abbreviationComponent,$abbreviationIngredient);
                $totalProduct = $quantityComponentConvert * $quantity;
                $enoughProduct = intval($quantityIngredient / $quantityComponentConvert);
            }
            if($totalProduct > $quantityIngredient){
                $noti += ['res' => 'warning', 'status' => 'Số lượng hiện tại không đủ để đặt hàng, chúng tôi chỉ có đủ '.$enoughProduct.' sản phẩm'];
            }
        }
        if(isset($noti['res']) && $noti['res'] == 'warning'){
            return response()->json(['res' => 'warning', 'title' => 'Thông báo đặt hàng', 'icon' => 'warning', 'status' => $noti['status']],200);
        }else{
            $isLogin = isset($data['isLogin']) ? $data['isLogin'] : '';
            if(!$isLogin){
                $sessionCart = Session::get('cart');
                $idSessionCart = isset($sessionCart[$data['id']]) ? $sessionCart[$data['id']] : '';
                if($idSessionCart){
                    $cart = $sessionCart[$data['id']];
                    $quantityUpdate = $cart['quantity_product'] + $data['quantity'];
                    $sessionCart[$data['id']]['quantity_product'] = $quantityUpdate;
                }else{
                    $sessionCart[$data['id']] = [
                        'image_product' => $product->image_product,
                        'name_product' => $product->name_product,
                        'quantity_product' => $data['quantity'],
                        'price_product' => $product->price_product,
                        'note_product' => $data['note'],
                    ]; 
                }
                Session::put('cart',$sessionCart);
            }else{
                echo 2;
            }
        }
    }

    function convertUnit($value, $fromUnit, $toUnit) {
        // Chuyển đơn vị đầu vào và đầu ra thành chữ thường để so sánh
        $fromUnit = strtolower($fromUnit);
        $toUnit = strtolower($toUnit);
    
        // Biến đổi giá trị dựa trên đơn vị đầu vào và đầu ra
        switch ("$fromUnit-$toUnit") {
            case 'kg-g':
                return $value * 1000; // 1 kg = 1000 g
            case 'g-kg':
                return $value / 1000; // 1 g = 0.001 kg
            case 'ml-l':
                return $value / 1000; // 1 ml = 0.001 l
            case 'l-ml':
                return $value * 1000; // 1 l = 1000 ml
            default:
                Log::error("Không thể chuyển đổi từ $fromUnit sang $toUnit");
                return null; // Trả về null nếu không thể chuyển đổi
        }
    }
}
