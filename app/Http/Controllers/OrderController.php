<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\CustomerCoupon;
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
    function list()
    {
        $title = 'Danh sách đơn hàng';
        $list = Order::all();
        return view('order.list', compact('title', 'list'));
    }

    function apply(Request $request)
    {
        $data = $request->all();
        // $order = session('order');
        // if(isset($order)){
        //     Session::flush('order');
        // }
        $validation = Validator::make($data, [
            'fullname_order' => ['required', 'regex:/^[a-zA-Z\sÀ-Ỹà-ỹ-]+$/u'],
            'phone_order' => ['required', 'regex:/^(03[2-9]|05[6-9]|07[06-9]|08[1-9]|09[0-9]|01[2-9])[0-9]{7}$/', 'max:10'],
            'address_order' => ['required']
        ], [
            'fullname_order.required' => 'Họ tên người đặt không được để trống',
            'fullname_order.regex' => 'Họ tên người đặt phải là chữ cái',
            'phone_order.regex' => 'Số điện thoại người đặt phải là số',
            'phone_order.required' => 'Số điện thoại người đặt không được để trống',
            'phone_order.max' => 'Số điện thoại người đặt phải là số điện thoại tại Việt Nam',
            'address_order.required' => 'Địa chỉ người đặt không được để trống',
        ]);
        if (!$validation->fails()) {
            $order = [
                'fullname' => $data['fullname_order'],
                'phone' => $data['phone_order'],
                'address' => $data['address_order'],
                'fee_ship' => $data['fee_ship'],
                'code_discount' => isset($data['code_discount']) ? $data['code_discount'] : '',
                'fee_discount' => $data['fee_discount'],
                'subtotal' => $data['subtotal'],
                'total' => $data['total']
            ];
            Session::put('order', $order);
            return response()->json(['res' => 'success']);
        } else {
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }

    function home()
    {
        $title = 'Đơn hàng';
        $cart = session('cart');
        $order = session('order');
        if (!isset($order)) {
            return redirect()->route('cart.home');
        } else {
            $idCustomer = request()->cookie('id_customer') ? request()->cookie('id_customer') : 0;
            $customer = request()->cookie('id_customer') ? Customer::find($idCustomer) : [];
            $list = Cart::where('id_customer', $idCustomer)->get();
            $news = News::orderBy('updated_at', 'desc')->limit(3)->get();
            $carts = array();
            $subtotal = 0;
            $total = 0;
            if (request()->cookie('id_customer')) {
                $carts = Cart::where('id_customer', request()->cookie('id_customer'))->get();
                foreach ($carts as $key => $one) {
                    $subtotal += intval($one['price_product']);
                }
                $total += $subtotal + intval($order['fee_ship']) - intval($order['fee_discount']);
            } else {
                foreach ($cart as $key => $one) {
                    $subtotal += intval($one['price_product']);
                }
                $total += $subtotal + intval($order['fee_ship']) - intval($order['fee_discount']);
            }
            $parentCategorys = Category::where('id_parent_category', 0)->get();
            $childCategorys = Category::where('id_parent_category', '!=', 0)->get();
            return view('order.home', compact('list', 'title', 'parentCategorys', 'childCategorys', 'order', 'subtotal', 'total', 'news'));
        }
    }

    function order(Request $request)
    {
        $data = $request->all();
        $order = session('order');
        $cart = session('cart');
        $idCustomer = request()->cookie('id_customer') ? request()->cookie('id_customer') : 0;
        if (isset($data['privacy'])) {
            $codeOrder = $this->randomCode();
            $dataOrder = [
                'code_order' => $codeOrder,
                'id_customer' => $idCustomer,
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
            if ($insertOrder) {
                $notis = [];
                //co tai khoan
                if ($idCustomer) {
                    $carts = Cart::where('id_customer', $idCustomer)->get();
                    foreach ($carts as $key => $one) {
                        $handleIngredients = $this->handleIngredients($one['id_product'], $one['quantity_product']);
                        // dd($handleIngredients);
                        if($handleIngredients['res'] == 'true'){
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
                                Cart::where('id_customer',$idCustomer)->delete();
                                $notis += ['res' => 'success'];
                            }else{
                                $notis += ['res' => 'fail'];
                            }
                        }else{
                            $notis['res'] = 'fail';
                            if (!isset($notis['status'])) {
                                $notis['status'] = [];
                            }
                            array_push($notis['status'], $handleIngredients['status']);
                        }
                    }
                    if ($order['code_discount'] != '') {
                        $coupon = Coupon::where('code_coupon', $order['code_discount'])->first();
                        $deleteCoupon = CustomerCoupon::where('id_customer', request()->cookie('id_customer'))->where('id_coupon', $coupon->id_coupon)->delete();
                    }
                    $this->handleGiftCoupon($dataOrder, $idCustomer); // tang ma khuyen mai
                    //khong tai khoan 
                } else {
                    foreach ($cart as $key => $one) {
                        $handleIngredients = $this->handleIngredients($key, $one['quantity_product']);
                        if ($handleIngredients['res'] == 'true') {
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
                                $notis += ['res' => 'success'];
                            }else{
                                $notis += ['res' => 'fail'];
                            }
                        } else {
                            $notis['res'] = 'fail';
                            if (!isset($notis['status'])) {
                                $notis['status'] = [];
                            }
                            array_push($notis['status'], $handleIngredients['status']);
                        }
                    }
                }
                if ($notis['res'] == 'success') {
                    $request->session()->forget('order');
                    $request->session()->forget('cart');
                    $request->session()->flush();
                    return response(['res' => 'success', 'status' => 'Thông báo đặt hàng', 'icon' => 'success', 'title' => 'Đặt hàng thành công!']);
                } else {
                    Order::find($insertOrder->id_order)->delete();
                    return response(['res' => 'fail', 'status' => 'Thông báo đặt hàng', 'icon' => 'error', 'title' => $notis['status']]);
                }
            } else {
                return response(['res' => 'fail', 'status' => 'Thông báo đặt hàng', 'icon' => 'error', 'title' => 'Đặt hàng thất bại do máy chủ']);
            }
        } else {
            return response(['res' => 'warning', 'status' => 'Hãy đồng ý với yêu cầu!']);
        }
    }

    function history()
    {
        $title = 'Lịch sử đơn hàng';
        $carts = array();
        $idCustomer = request()->cookie('id_customer');
        $carts = Cart::where('id_customer',$idCustomer)->get();
        $orders = Order::where('id_customer',$idCustomer)->get();
        $parentCategorys = Category::where('id_parent_category', 0)->get();
        $childCategorys = Category::where('id_parent_category', '!=', 0)->get();
        return view('order.history', compact('title', 'parentCategorys', 'childCategorys', 'carts','orders'));
    }

    function handleGiftCoupon($order, $idCustomer)
    {
        $noti = [];
        $coupons = Coupon::where('expiration_time', '>=', date('Y-m-d'))->get();
        foreach ($coupons as $key => $coupon) {
            $subtotal = intval($order['subtotal_order']);
            $isPrice = intval($coupon->is_price);
            $existCouponCustomer = CustomerCoupon::where('id_customer', $idCustomer)->where('id_coupon', $coupon->id_coupon)->first(); //ktra ton tai
            if (!$existCouponCustomer) {
                if ($subtotal >= $isPrice && $isPrice != 0) {
                    $dataCoupon = [
                        'id_customer' => $idCustomer,
                        'id_coupon' => $coupon->id_coupon,
                    ];
                    $insert = CustomerCoupon::create($dataCoupon);
                }
                $existOrder = Order::where('id_customer', $idCustomer)->get();
                $countOrder = count($existOrder);
                $isBuy = $coupon->is_buy;
                if ($countOrder == $isBuy && $isBuy != 0) {
                    $dataCoupon = [
                        'id_customer' => $idCustomer,
                        'id_coupon' => $coupon->id_coupon,
                    ];
                    $insert = CustomerCoupon::create($dataCoupon);
                }
            } else {
                $noti += ['res' => 'false'];
            }
        }
    }

    function randomCode($length = 6)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    function convertUnit($value, $fromUnit, $toUnit)
    {
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

    function handleIngredients($id, $quantity)
    {
        $recipe = Recipe::where('id_product', $id)->first();
        $product = Product::find($id);
        $name = $product->name_product;
        if ($recipe) {
            $components = json_decode($recipe->component_recipe);
            $isTrue = false;
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
                $enoughProduct = 0;
                $quantityComponentConvert = 0;
                if ($abbreviationComponent == $abbreviationIngredient) { //ktra 2 don vi giong nhau k 
                    $totalProduct = $quantityComponent * $quantity; // tong so luong hien tai
                    $enoughProduct = intval($quantityIngredient / $quantityComponent);
                    $quantityComsumptions = $quantityIngredient - ($quantityComponent * $quantity); //so luong tieu thu
                } else {
                    $quantityComponentConvert = $this->convertUnit($quantityComponent, $abbreviationComponent, $abbreviationIngredient);
                    $totalProduct = $quantityComponentConvert * $quantity;
                    $enoughProduct = intval($quantityIngredient / $quantityComponentConvert);
                    $quantityComsumptions = $quantityIngredient - ($quantityComponentConvert * $quantity); //so luong tieu thu
                }
                $array = [
                    'id' => $one->id_ingredient,
                    'quantity' => $quantityComsumptions,
                ];
                array_push($arrIngredients, $array);
                if ($totalProduct > $quantityIngredient) {
                    $isTrue = false;
                } else {
                    $isTrue = true;
                }
            }
            //xu ly tat ca nguyen lieu trong 1 san pham deu du
            if (!$isTrue) {
                return ['res' => 'false', 'status' => $name . ' chỉ còn ' . $enoughProduct . ' sản phẩm'];
            } else {
                $noti = [];
                foreach ($arrIngredients as $key => $one) {
                    $itemIngredient = Ingredients::find($one['id']);
                    $itemIngredient->quantity_ingredient = $one['quantity'];
                    $updateIngredients = $itemIngredient->save();
                    if ($updateIngredients) {
                        $noti += ['res' => 'true'];
                    } else {
                        $noti += ['res' => 'false', 'status' => 'Lỗi truy vấn'];
                    }
                }
                return $noti;
            }
        }
    }
}
