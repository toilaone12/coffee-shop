<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Ingredients;
use App\Models\Notification;
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
        $notifications = array();
        if(request()->cookie('id_customer')){
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
            $notifications = Notification::where('id_customer', request()->cookie('id_customer'))->get();
        }
        $relatedProduct = Product::whereIn('id_category',$arrayIdCategory)->get();
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        return view('cart.home',compact('notifications','list','title','parentCategorys','childCategorys','relatedProduct', 'cart', 'customer','carts'));
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

}
