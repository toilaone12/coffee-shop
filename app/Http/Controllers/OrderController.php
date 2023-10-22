<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DetailOrder;
use App\Models\Ingredients;
use App\Models\News;
use App\Models\Order;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Integer;

class OrderController extends Controller
{
    //
    function list(){
        $title = 'Danh sách đơn hàng';
        $list = Order::all();
        return view('order.list',compact('title','list'));
    }

    function apply(Request $request){
        $data = $request->all();
        // $order = session('order');
        // if(isset($order)){
        //     Session::flush('order');
        // }
        $validation = Validator::make($data,[
            'fullname_order' => ['required', 'regex:/^[a-zA-Z\sÀ-Ỹà-ỹ-]+$/u'],
            'phone_order' => ['required', 'regex:/^(03[2-9]|05[6-9]|07[06-9]|08[1-9]|09[0-9]|01[2-9])[0-9]{7}$/', 'max:10'],
            'address_order' => ['required'] 
        ],[
            'fullname_order.required' => 'Họ tên người đặt không được để trống',
            'fullname_order.regex' => 'Họ tên người đặt phải là chữ cái',
            'phone_order.regex' => 'Số điện thoại người đặt phải là số',
            'phone_order.required' => 'Số điện thoại người đặt không được để trống',
            'phone_order.max' => 'Số điện thoại người đặt phải là số điện thoại tại Việt Nam',
            'address_order.required' => 'Địa chỉ người đặt không được để trống',
        ]);
        if(!$validation->fails()){
            $order = [
                'fullname' => $data['fullname_order'],
                'phone' => $data['phone_order'],
                'address' => $data['address_order'],
                'fee_ship' => $data['fee_ship'],
                'code_discount' => $data['code_discount'],
                'fee_discount' => $data['fee_discount'],
                'subtotal' => $data['subtotal'],
                'total' => $data['total']
            ];
            Session::put('order',$order);
            return response()->json(['res' => 'success']);
        }else{
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }

    function home(){
        $title = 'Đơn hàng';
        $cart = session('cart');
        $order = session('order');
        $idCustomer = request()->cookie('id_customer') ? request()->cookie('id_customer') : 0;
        $customer = request()->cookie('id_customer') ? Customer::find($idCustomer) : [];
        $list = Cart::where('id_customer',$idCustomer)->get();
        $news = News::orderBy('updated_at', 'desc')->limit(3)->get();
        $carts = array();
        $subtotal = 0;
        $total = 0;
        if(request()->cookie('id_customer')){
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
            foreach($carts as $key => $one){
                $subtotal += intval($one['price_product']);
            }
            $total += $subtotal + intval($order['fee_ship']) - intval($order['fee_discount']);
        }else{
            foreach($cart as $key => $one){
                $subtotal += intval($one['price_product']);
            }
            $total += $subtotal + intval($order['fee_ship']) - intval($order['fee_discount']);
        }
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        return view('order.home',compact('list','title','parentCategorys','childCategorys','order','subtotal','total','news'));
    }

    function order(Request $request){
        $data = $request->all();
        $order = session('order');
        $cart = session('cart');
        if(isset($data['privacy'])){
            $codeOrder = $this->randomCode();
            $dataOrder = [
                'code_order' => $codeOrder,
                'name_order' => $order['fullname'],
                'phone_order' => $order['phone'],
                'subtotal_order' => $order['subtotal'],
                'fee_ship' => $order['fee_ship'],
                'fee_discount' => $order['fee_discount'],
                'address_order' => $order['address'],
                'total_order' => $order['total'],
                'status_order' => 0
            ];
            $insertOrder = Order::create($dataOrder);
            // $insertOrder = true;
            if($insertOrder){
                $noti = [];
                //co tai khoan
                if(request()->cookie('id_customer')){
                    $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
                    foreach($carts as $key => $one){
                        $handleIngredients = $this->handleIngredients($one['id_product'], $one['quantity_product']);
                        if($handleIngredients){
                            $dataDetailOrder = [
                                'id_order' => $insertOrder->id_order,
                                'code_order' => $codeOrder,
                                'image_product' => $one['image_product'],
                                'name_product' => $one['name_product'],
                                'quantity_product' => $one['quantity_product'],
                                'price_product' => $one['price_product'],
                                'note_product' => $one['note_product'],
                            ];
                            $insertDetail = DetailOrder::create($dataDetailOrder);
                            if($insertDetail){
                                $carts->delete();
                                $noti += ['res' => 'success'];
                            }else{
                                $noti += ['res' => 'fail'];
                            }
                        }
                    } 
                //khong tai khoan 
                }else{
                    foreach($cart as $key => $one){
                        $handleIngredients = $this->handleIngredients($one['id_product'], $one['quantity_product']);
                        if($handleIngredients){
                            $dataDetailOrder = [
                                'id_order' => $insertOrder->id_order,
                                'code_order' => $codeOrder,
                                'image_product' => $one['image_product'],
                                'name_product' => $one['name_product'],
                                'quantity_product' => $one['quantity_product'],
                                'price_product' => $one['price_product'],
                                'note_product' => $one['note_product'],
                            ];
                            $insertDetail = DetailOrder::create($dataDetailOrder);
                            if($insertDetail){
                                $noti += ['res' => 'success'];
                            }else{
                                $noti += ['res' => 'fail'];
                            }
                        }
                    }
                }
                if($noti['res'] == 'success'){
                    return response(['res' => 'success','status' => 'Thông báo đặt hàng', 'icon' => 'success', 'title' => 'Đặt hàng thành công!']);
                }else{
                    return response(['res' => 'fail','status' => 'Thông báo đặt hàng', 'icon' => 'fail', 'title' => 'Đặt hàng thất bại do máy chủ']);
                }
                if(isset($order)){
                    Session::forget('order');
                }
            }else{
                return response(['res' => 'fail','status' => 'Thông báo đặt hàng', 'icon' => 'fail', 'title' => 'Đặt hàng thất bại do máy chủ']);
            }
        }else{
            return response(['res' => 'warning', 'status' => 'Hãy đồng ý với yêu cầu!']);
        }
    }

    function randomCode($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
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
            foreach($components as $key => $one){
                $unitComponent = Units::find(intval($one->id_unit)); // tim don vi cua thanh phan trong cong thuc
                $ingredient = Ingredients::find(intval($one->id_ingredient)); //tim nguyen lieu trong ds nguyen lieu
                $unitIngredient = Units::find(intval($ingredient->id_unit));//tim don vi cua nguyen lieu
                $abbreviationComponent = $unitComponent->abbreviation_unit; //ky hieu don vi cua thanh phan trong cong thuc
                $abbreviationIngredient = $unitIngredient->abbreviation_unit; //ky hieu don vi cua nguyen lieu
                $quantityIngredient = floatval($ingredient->quantity_ingredient); //so luong nguyen lieu
                $quantityComponent = intval($one->quantity_recipe_need); // so luong cua thanh phan trong nguyen lieu
                $quantityComsumption = 0;
                $quantityComponentConvert = 0;
                if($abbreviationComponent == $abbreviationIngredient){ //ktra 2 don vi giong nhau k 
                    $quantityComsumption = $quantityIngredient - ($quantityComponent * $quantity); //so luong tieu thu
                }else{
                    $quantityComponentConvert = $this->convertUnit($quantityComponent,$abbreviationComponent,$abbreviationIngredient);
                    $quantityComsumption = $quantityIngredient - ($quantityComponentConvert * $quantity); //so luong tieu thu
                }
                $ingredient->quantity_ingredient = $quantityComsumption;
                $updateIngredients = $ingredient->save();
                if($updateIngredients){
                    $noti += ['res' => 'true'];
                }else{
                    $noti += ['res' => 'false'];
                }
            }
            if($noti['res'] == 'true'){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
