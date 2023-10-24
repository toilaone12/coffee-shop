<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Ingredients;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //page
    function insert(Request $request){
        // Session::forget('cart');
        $data = $request->all();
        $quantity = intval($data['quantity']); // so luong them
        $product = Product::find($data['id']);
        $noti = $this->handleIngredients($data['id'],$quantity);
        // dd($noti);
        if($noti['res'] == 'false'){
            return response()->json(['res' => 'warning', 'title' => 'Thông báo đặt hàng', 'icon' => 'warning', 'status' => $noti['status']],200);
        }else{
            $isLogin = isset($data['isLogin']) ? $data['isLogin'] : '';
            if(!$isLogin){
                $sessionCart = Session::get('cart');
                $idSessionCart = isset($sessionCart[$data['id']]) ? $sessionCart[$data['id']] : '';
                if($idSessionCart){
                    $cart = $sessionCart[$data['id']];
                    $quantityUpdate = $cart['quantity_product'] + $data['quantity'];
                    $priceUpdate = intval($product->price_product) * $quantityUpdate;
                    $sessionCart[$data['id']]['quantity_product'] = $quantityUpdate;
                    $sessionCart[$data['id']]['price_product'] = $priceUpdate;
                }else{
                    $sessionCart[$data['id']] = [
                        'image_product' => $product->image_product,
                        'name_product' => $product->name_product,
                        'quantity_product' => $data['quantity'],
                        'price_product' => intval($product->price_product) * intval($data['quantity']),
                        'note_product' => $data['note'],
                    ]; 
                }
                Session::put('cart',$sessionCart);
                return response()->json(['res' => 'success', 'title' => 'Thêm vào giỏ hàng', 'icon' => 'success', 'status' => 'Lưu vào giỏ hàng thành công!']);
            }else{
                $idCustomer = request()->cookie('id_customer');
                $cart = Cart::where('id_customer',$idCustomer)->where('id_product',$data['id'])->first();
                if($cart){
                    $quantityUpdate = intval($cart->quantity_product) + $quantity;
                    $priceUpdate = intval($product->price_product) * $quantityUpdate;
                    $cart->quantity_product = $quantityUpdate;
                    $cart->price_product = $priceUpdate;
                    $cart->note_product = $data['note'];
                    $update = $cart->save();
                    if($update){
                        return response()->json(['res' => 'success', 'title' => 'Thêm vào giỏ hàng', 'icon' => 'success', 'status' => 'Lưu vào giỏ hàng thành công!']);
                    }else{
                        return response()->json(['res' => 'fail', 'title' => 'Thêm vào giỏ hàng', 'icon' => 'error', 'status' => 'Lưu vào giỏ hàng thất bại!']);
                    }
                }else{
                    $data = [
                        'id_customer' => $idCustomer,
                        'id_product' => $data['id'],
                        'image_product' => $product->image_product,
                        'name_product' => $product->name_product,
                        'quantity_product' => $quantity,
                        'price_product' => intval($product->price_product) * $quantity,
                        'note_product' => $data['note'],
                    ];
                    $insert = Cart::create($data);
                    if($insert){
                        return response()->json(['res' => 'success', 'title' => 'Thêm vào giỏ hàng', 'icon' => 'success', 'status' => 'Lưu vào giỏ hàng thành công!']);
                    }else{
                        return response()->json(['res' => 'fail', 'title' => 'Thêm vào giỏ hàng', 'icon' => 'error', 'status' => 'Lưu vào giỏ hàng thất bại!']);
                    }
                }
            }
        }
    }

    function home(){
        $title = 'Giỏ hàng';
        $cart = session('cart');
        $idCustomer = request()->cookie('id_customer') ? request()->cookie('id_customer') : 0;
        $customer = request()->cookie('id_customer') ? Customer::find($idCustomer) : [];
        $list = Cart::where('id_customer',$idCustomer)->get();
        $arrayIdCategory = array();
        if($cart){
            foreach($cart as $key => $one){
                $product = Product::find($key);
                if($product){
                    $category = Category::find($product->id_category);
                    array_push($arrayIdCategory,$category->id_category);
                }
            }
        }else{
            foreach($list as $key => $one){
                $product = Product::find($one->id_product);
                if($product){
                    $category = Category::find($product->id_category);
                    array_push($arrayIdCategory,$category->id_category);
                }
            }
        }
        $carts = array();
        if(request()->cookie('id_customer')){
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
        }
        $relatedProduct = Product::whereIn('id_category',$arrayIdCategory)->get();
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        return view('cart.home',compact('list','title','parentCategorys','childCategorys','relatedProduct', 'cart', 'customer','carts'));
    }

    function delete(Request $request){
        $id = $request->get('id');
        $cart = Session::get('cart');
        if(isset($cart)){
            unset($cart[$id]);
            Session::put('cart',$cart);
            if(count($cart) == 0){
                Session::forget('cart');
            }
        }else{
            $delete = Cart::where('id_product',$id)->where('id_customer', request()->cookie('id_customer'))->delete();
        }
        return redirect()->route('cart.home');
    }

    function update(Request $request){
        $data = $request->all();
        $id = $data['id'];
        $product = Product::find($id);
        $quantity = $data['quantity'];
        $cart = Session::get('cart');
        
        if(isset($noti['res']) && $noti['res'] == 'warning'){
            return response()->json(['res' => 'warning', 'title' => 'Thông báo đặt hàng', 'icon' => 'warning', 'status' => $noti['status'], 'quantity' => $noti['quantity']],200);
        }else{
            $isLogin = isset($data['isLogin']) ? $data['isLogin'] : '';
            if(!$isLogin){
                $sessionCart = Session::get('cart');
                $idSessionCart = isset($sessionCart[$data['id']]) ? $sessionCart[$data['id']] : '';
                if($idSessionCart){
                    $total = 0;
                    $cart = $sessionCart[$data['id']];
                    $quantityUpdate = $data['quantity'];
                    $priceUpdate = intval($product->price_product) * $quantityUpdate;
                    $sessionCart[$data['id']]['quantity_product'] = $quantityUpdate;
                    $sessionCart[$data['id']]['price_product'] = $priceUpdate;
                    foreach($sessionCart as $key => $one){
                        if($key == $data['id']){
                            $total += $priceUpdate;
                        }else{
                            $total += $one['price_product'];
                        }
                    }
                }
                Session::put('cart',$sessionCart);
                return response()->json(['res' => 'success', 'title' => 'Cập nhật số lượng vào giỏ hàng', 'icon' => 'success', 'status' => 'Lưu vào giỏ hàng thành công!', 'total' => $total]);
            }else{
                $idCustomer = request()->cookie('id_customer');
                $cart = Cart::where('id_customer',$idCustomer)->where('id_product',$data['id'])->first();
                if($cart){
                    $quantityUpdate = $quantity;
                    $priceUpdate = intval($product->price_product) * $quantity;
                    $cart->quantity_product = $quantityUpdate;
                    $cart->price_product = $priceUpdate;
                    $update = $cart->save();
                    $carts = Cart::where('id_customer',$idCustomer)->get();
                    $total = 0;
                    foreach($carts as $key => $one){
                        if($one->id_product == $data['id']){
                            $total += $priceUpdate;
                        }else{
                            $total += $one->price_product;
                        }
                    }
                    if($update){
                        return response()->json(['res' => 'success', 'title' => 'Cập nhật số lượng vào giỏ hàng', 'icon' => 'success', 'status' => 'Cập nhật số lượng sản phẩm trong giỏ hàng thành công!', 'total' => $total]);
                    }else{
                        return response()->json(['res' => 'fail', 'title' => 'Cập nhật số lượng vào giỏ hàng', 'icon' => 'error', 'status' => 'Cập nhật số lượng sản phẩm trong giỏ hàng thất bại!']);
                    }
                }
            }
        }
        // Session::put('cart',$cart);
    }

    function updateNote(Request $request){
        $data = $request->all();
        $isLogin = isset($data['isLogin']) ? $data['isLogin'] : '';
        if(!$isLogin){
            $sessionCart = Session::get('cart');
            $idSessionCart = isset($sessionCart[$data['id']]) ? $sessionCart[$data['id']] : '';
            if($idSessionCart){
                $cart = $sessionCart[$data['id']];
                $noteUpdate = $data['note'];
                $sessionCart[$data['id']]['note_product'] = $noteUpdate;
            }
            Session::put('cart',$sessionCart);
            return response()->json(['res' => 'success', 'title' => 'Cập nhật ghi chú', 'icon' => 'success', 'status' => 'Cập nhật ghi chú thành công!']);
        }else{
            $idCustomer = request()->cookie('id_customer');
            $cart = Cart::where('id_customer',$idCustomer)->where('id_product',$data['id'])->first();
            if($cart){
                $noteUpdate = $data['note'];
                $cart->note_product = $noteUpdate;
                $update = $cart->save();
                if($update){
                    return response()->json(['res' => 'success', 'title' => 'Cập nhật ghi chú giỏ hàng', 'icon' => 'success', 'status' => 'Cập nhật ghi chú thành công!']);
                }else{
                    return response()->json(['res' => 'fail', 'title' => 'Cập nhật ghi chú giỏ hàng', 'icon' => 'error', 'status' => 'Cập nhật ghi chú thất bại!']);
                }
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

    function handleIngredients($id, $quantity){
        $recipe = Recipe::where('id_product',$id)->first();
        $noti = [];
        if($recipe){
            $components = json_decode($recipe->component_recipe);
            $isTrue = false;
            foreach($components as $key => $one){
                $unitComponent = Units::find(intval($one->id_unit)); // tim don vi cua thanh phan trong cong thuc
                $ingredient = Ingredients::find(intval($one->id_ingredient)); //tim nguyen lieu trong ds nguyen lieu
                $unitIngredient = Units::find(intval($ingredient->id_unit));//tim don vi cua nguyen lieu
                $abbreviationComponent = $unitComponent->abbreviation_unit; //ky hieu don vi cua thanh phan trong cong thuc
                $abbreviationIngredient = $unitIngredient->abbreviation_unit; //ky hieu don vi cua nguyen lieu
                $quantityIngredient = floatval($ingredient->quantity_ingredient); //so luong nguyen lieu
                $quantityComponent = intval($one->quantity_recipe_need); // so luong cua thanh phan trong nguyen lieu
                $totalProduct = 0;
                $enoughProduct = 0;
                $quantityComsumption = 0;
                $quantityComponentConvert = 0;
                if($abbreviationComponent == $abbreviationIngredient){ //ktra 2 don vi giong nhau k 
                    $totalProduct = $quantityComponent * $quantity; // tong so luong hien tai
                    $enoughProduct = intval($quantityIngredient / $quantityComponent);
                    $quantityComsumption = $quantityIngredient - ($quantityComponent * $quantity); //so luong tieu thu
                }else{
                    $quantityComponentConvert = $this->convertUnit($quantityComponent,$abbreviationComponent,$abbreviationIngredient);
                    $totalProduct = $quantityComponentConvert * $quantity;
                    $enoughProduct = intval($quantityIngredient / $quantityComponentConvert);
                    $quantityComsumption = $quantityIngredient - ($quantityComponentConvert * $quantity); //so luong tieu thu
                }
                
                if($totalProduct > $quantityIngredient){
                    $isTrue = false;
                }else{
                    $isTrue = true;
                }
                if(!$isTrue){
                    $noti = ['res' => 'false', 'status' => 'Số lượng hiện tại không đủ để đặt hàng, chúng tôi chỉ có đủ '.$enoughProduct.' sản phẩm'];
                }else{
                    $ingredient->quantity_ingredient = $quantityComsumption;
                    $updateIngredients = $ingredient->save();
                    if($updateIngredients){
                        $noti += ['res' => 'true'];
                    }else{
                        $noti += ['res' => 'false', 'status' => 'Lỗi truy vấn'];
                    }
                }
            }
            return $noti;
        }else{
            return false;
        }
    }
}
