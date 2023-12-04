<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\CustomerCoupon;
use App\Models\DetailNote;
use App\Models\DetailOrder;
use App\Models\Ingredients;
use App\Models\News;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Statistic;
use App\Models\Units;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Integer;

class OrderController extends Controller
{
    //admin
    function list()
    {
        $title = 'Danh sách đơn hàng';
        $list = Order::all();
        $notifications = Notification::where('id_account', request()->cookie('id_account'))->orderBy('id_notification', 'desc')->limit(7)->get();
        $all = Notification::where('id_account', request()->cookie('id_account'))->get();
        $dot = false;
        foreach ($all as $noti) {
            if ($noti->is_read == 0) {
                $dot = true;
            } else {
                $dot = false;
            }
        }
        return view('order.list', compact('title', 'list', 'notifications', 'dot'));
    }

    function adminDetail($code)
    {
        $title = 'Chi tiết đơn hàng #' . $code;
        $order = Order::where('code_order', $code)->first();
        $list = DetailOrder::where('code_order', $code)->get();
        $notifications = Notification::where('id_account', request()->cookie('id_account'))->orderBy('id_notification', 'desc')->limit(7)->get();
        $all = Notification::where('id_account', request()->cookie('id_account'))->get();
        $dot = false;
        foreach ($all as $noti) {
            if ($noti->is_read == 0) {
                $dot = true;
            } else {
                $dot = false;
            }
        }
        $listStatus = [
            3 => 'Nhận đơn hàng',
            4 => 'Giao cho vận chuyển',
            5 => 'Giao thành công',
        ];
        return view('order.admin_detail', compact('title', 'order', 'list', 'listStatus', 'notifications', 'dot'));
    }

    function create()
    {
        $orderDetail = DetailOrder::where('updated_at', 'like', "%2023-10-31%")->get();
        return response()->json(['res' => 'success', 'detail' => $orderDetail]);
    }

    function check(Request $request)
    {
        $id = $request->get('id');
        $noti = [];
        $handleIngredients = [];
        $orderDetail = DetailOrder::where('id_order', $id)->get();
        foreach ($orderDetail as $key => $one) {
            $handleIngredients[] = $this->handleIngredients($one['id_product'], $one['quantity_product']);
        }
        //xu ly loc cac san pham trung nhau de lay tong so luong nguyen lieu can dung 
        $sums = [];
        foreach ($handleIngredients as $item) {
            foreach ($item as $key => $value) {
                // Kiểm tra xem khóa đã tồn tại trong mảng tổng hay chưa
                if (!isset($sums[$key]['quantityProduct'])) {
                    $sums[$key]['quantityIngredient'] = $value['quantityIngredient']; // Giữ nguyên giá trị 'quantityIngredient'
                    $sums[$key]['quantityProduct'] = 0;
                }
                // Thực hiện cộng giá trị 'quantity' vào mảng tổng
                $sums[$key]['quantityProductBuy'][] = $value['quantityProductBuy']; //  so luong mua cua khach
                $sums[$key]['nameProduct'][] = $value['nameProduct']; // ten sp
                $sums[$key]['nameIngredient'][] = $value['nameIngredient']; // ten sp
                $sums[$key]['enoughProduct'][] = $value['enoughProduct']; // so luong du
                $sums[$key]['quantityProduct'] += $value['quantityProduct']; // so luong cong lai khi trung san pham
                $sums[$key]['totalIngredientOneProduct'][] = $value['quantityProduct']; // so luong khi lam ra san pham
                $sums[$key]['ingredientRecipeNeed'][] = $value['ingredientRecipeNeed']; // so luong nguyen lieu can trong cong thuc
            }
        }
        //tinh toan de dua ra lieu san pham co du khong
        $checkProduct = [];
        $isIngredients = true;
        foreach ($sums as $key => $sum) {
            if ($sum['quantityIngredient'] < $sum['quantityProduct']) {
                $quantityIngredient = $sum['quantityIngredient'];
                foreach ($sum['totalIngredientOneProduct'] as $index => $total) {
                    if (isset($sum['enoughProduct'][$index])) {
                        if ($quantityIngredient > $total) {
                            $quantityIngredient -= $total;
                        } else {
                            $quantityComsumptions = $quantityIngredient / $sum['ingredientRecipeNeed'][$index];
                            $isIngredients = false;
                            $checkProduct[] = [
                                'id' => $key,
                                'name' => $sum['nameProduct'][$index],
                                'nameIngredient' => $sum['nameIngredient'][$index],
                                'quantityComsumptions' => intval($quantityComsumptions),
                            ];
                            // break;
                        }
                    }
                }
            }
        }
        // dd($checkProduct);
        if (!$isIngredients) {
            $error = '<span class="d-block fs-20 text-left">Do có: </span>';
            $uniqueNames = [];
            foreach ($checkProduct as $key => $check) {
                $name = $check['name'];
                if (!in_array($name, $uniqueNames)) {
                    $uniqueNames[] = $name;
                    $error .= '<span class="text-danger text-left fs-18 d-block">+) Món ' . $name;
                } else {
                    $error .= ' và';
                }
                $error .= $check['quantityComsumptions'] ? ' chỉ còn đủ ' . $check['quantityComsumptions'] : ' không còn đủ ';
                $error .= ' sản phẩm do';
                $error .= $check['quantityComsumptions'] ? ' thiếu nguyên liệu ' . $check['nameIngredient'] : ' sản phẩm trên đã sử dụng hết ';
            }
            $error .= '</span>';
            $error .= '<span class="text-danger text-left fs-18 d-block">=> Cho nên sẽ không đặt được các sản phẩm còn lại </span>';
            $noti['status'] = $error;
            return response()->json(['res' => 'fail', 'title' => 'Thông báo kiểm tra đơn hàng', 'icon' => 'error', 'status' => $noti['status']]);
        } else {
            $order = Order::find($id);
            $order->status_order = 1;
            $update = $order->save();
            if ($update) {
                return response()->json(['res' => 'success', 'title' => 'Thông báo kiểm tra đơn hàng', 'icon' => 'success', 'status' => 'Đủ nguyên liệu để chế biến sản phẩm']);
            } else {
                return response()->json(['res' => 'fail', 'title' => 'Thông báo kiểm tra đơn hàng', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }
    }

    function updateQuantityAfterOrder(Request $request)
    {
        $data = $request->all();
        $detail = DetailOrder::find($data['id']);
        $price = $detail->price_product / $detail->quantity_product;
        $total = $data['quantity'] * $price;
        $detail->quantity_product = $data['quantity'];
        $detail->price_product = $total;
        $update = $detail->save();
        if ($update) {
            $list = DetailOrder::where('id_order',$detail->id_order)->get();
            $allTotal = 0;
            foreach($list as $one){
                $allTotal += $one->price_product;
            }
            $order = Order::find($detail->id_order);
            $order->subtotal_order = $allTotal;
            $order->total_order = $allTotal + $order->fee_discount + $order->fee_ship;
            $update = $order->save();
            if($update){
                return response()->json(['res' => 'success', 'title' => 'Thông báo chỉnh số lượng đơn hàng', 'icon' => 'success', 'status' => 'Chỉnh số lượng đơn hàng thành công', 'total' => $total]);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Thông báo chỉnh số lượng đơn hàng', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        } else {
            return response()->json(['res' => 'fail', 'title' => 'Thông báo chỉnh số lượng đơn hàng', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    //page
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
            'address_order' => ['required'],
            'email_order' => ['required'],
        ], [
            'fullname_order.required' => 'Họ tên người đặt không được để trống',
            'fullname_order.regex' => 'Họ tên người đặt phải là chữ cái',
            'phone_order.regex' => 'Số điện thoại người đặt phải là số',
            'phone_order.required' => 'Số điện thoại người đặt không được để trống',
            'phone_order.max' => 'Số điện thoại người đặt phải là số điện thoại tại Việt Nam',
            'address_order.required' => 'Địa chỉ người đặt không được để trống',
            'email_order.required' => 'Email người đặt không được để trống',
        ]);
        if (!$validation->fails()) {
            $order = [
                'fullname' => $data['fullname_order'],
                'phone' => $data['phone_order'],
                'address' => $data['address_order'],
                'email' => $data['email_order'],
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
            $notis = [];
            //co tai khoan
            if ($idCustomer) {
                $handle = $this->handleOrderWithDB($idCustomer, $codeOrder, $order);
                $notis = $handle;
                //khong tai khoan 
            } else {
                $handle = $this->handleOrderWithSession($idCustomer, $codeOrder, $order, $cart);
                $notis = $handle;
            }
            if ($notis['res'] == 'success') {
                $randomAccount = Account::where('is_online', 1)->inRandomOrder()->first();
                if ($randomAccount) {
                    $randomId = $randomAccount->id_account;
                    // dd($randomId);
                    // Sử dụng $randomId cho mục đích của bạn
                    $request->session()->forget('order');
                    $request->session()->forget('cart');
                    $request->session()->flush();
                    return response(['res' => 'success', 'status' => 'Thông báo đặt hàng', 'icon' => 'success', 'title' => 'Đặt hàng thành công!', 'code' => $codeOrder, 'id' => $randomId]);
                }
            } else {
                return response(['res' => 'fail', 'status' => 'Thông báo đặt hàng', 'icon' => 'error', 'title' => $notis['status']]);
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
        $carts = Cart::where('id_customer', $idCustomer)->get();
        $orders = Order::where('id_customer', $idCustomer)->get();
        $parentCategorys = Category::where('id_parent_category', 0)->get();
        $childCategorys = Category::where('id_parent_category', '!=', 0)->get();
        return view('order.history', compact('title', 'parentCategorys', 'childCategorys', 'carts', 'orders'));
    }

    function detail($code)
    {
        $title = 'Chi tiết đơn hàng';
        $carts = array();
        $idCustomer = request()->cookie('id_customer');
        $carts = Cart::where('id_customer', $idCustomer)->get();
        $order = Order::where('code_order', $code)->first();
        $orderDetail = DetailOrder::where('code_order', $code)->get();
        $status = $order->status_order;
        $parentCategorys = Category::where('id_parent_category', 0)->get();
        $childCategorys = Category::where('id_parent_category', '!=', 0)->get();
        return view('order.detail', compact('title', 'parentCategorys', 'childCategorys', 'carts', 'order', 'orderDetail', 'status'));
    }

    function change(Request $request)
    {
        $data = $request->all();
        $status = intval($data['status']);
        $id = $data['id'];
        $order = Order::find($id);
        if ($order->status_order + 1 == $status) {
            $order->status_order = $status;
            $order->date_updated = date('Y-m-d');
            $update = $order->save();
            if ($update) {
                if ($status == 5) {
                    return redirect()->route('order.detail', ['code' => $order->code_order]);
                } else {
                    $code = $order->code_order;
                    $id = $order->id_customer;
                    if ($status == 2 && $id) {
                        $this->handlePushNotification($id, $code, 'Đơn của bạn đã được nhận đơn, vui lòng chờ đợi chốc lát', 'Bạn đã nhận đơn hàng');
                    } else if ($status == 3 && $id) {
                        $this->handlePushNotification($id, $code, 'Đơn của bạn đang được vận chuyển, vui lòng chờ đợi chốc lát', 'Bạn đã giao đơn cho bên vận chuyển');
                    } else if ($status == 4) {
                        $this->handleStatistic($order);
                        if ($id) $this->handlePushNotification($id, $code, 'Đơn của bạn đã được giao thành công, cảm ơn bạn vì đã mua hàng', 'Bạn đã nhận thông báo nhận hàng thành công từ khách hàng');
                    }
                    return redirect()->route('order.adDetail', ['code' => $order->code_order]);
                }
            }
        } else {
            if ($status == 4) {
                return redirect()->route('order.detail', ['code' => $order->code_order]);
            } else {
                return redirect()->route('order.adDetail', ['code' => $order->code_order]);
            }
        }
    }

    function export(Request $request)
    {
        $code = $request->get('code');
        $title = 'Hóa đơn #' . $code;
        $order = Order::where('code_order', $code)->first();
        $details = DetailOrder::where('code_order', $code)->get();
        return view('order.pdf', compact('order', 'details', 'title'));
    }

    function search(Request $request)
    {
        $data = $request->all();
        $orders = Order::whereBetween('date_updated', [$data['date-from'], $data['date-to']])->get();
        $arrDetail = [];
        foreach ($orders as $key => $one) {
            if ($one->status_order == 3) {
                $orderDetail = DetailOrder::where("id_order", $one->id_order)->get();
                foreach ($orderDetail as $key => $detail) {
                    $name = $detail->name_product;
                    $quantity = $detail->quantity_product;
                    // Nếu sản phẩm đã tồn tại trong mảng $arrDetail
                    $existingKey = array_search($name, array_column($arrDetail, 'name')); //array_column: tao 1 mang moi chi co cot name
                    //existingKey se tra ve key dung
                    if ($existingKey !== false) {
                        // Tăng số lượng cho sản phẩm đã tồn tại
                        $arrDetail[$existingKey]['quantity'] += $quantity;
                    } else {
                        // Thêm sản phẩm mới vào mảng
                        $arrDetail[] = [
                            'name' => $name,
                            'quantity' => $quantity
                        ];
                    }
                }
            }
        }
        return response()->json(['res' => 'success', 'arrDetail' => $arrDetail, 'from' => date('d-m-Y', strtotime($data['date-from'])), 'to' => date('d-m-Y', strtotime($data['date-to']))]);
    }

    function filter(Request $request)
    {
        $data = $request->all();
        $choose = $data['option'];
        $dateNow = Carbon::now()->toDateString();
        $filter = '';
        if ($choose == '7days') {
            $filter = Carbon::now()->subDay(7)->toDateString(); // lop xu ly datetime
        } else if ($choose == '1month') {
            $filter = Carbon::now()->subMonth(1)->toDateString(); // lop xu ly datetime
        } else if ($choose == '3months') {
            $filter = Carbon::now()->subMonth(3)->toDateString(); // lop xu ly datetime
        } else {
            $filter = $dateNow;
        }
        $orders = Order::whereBetween('date_updated', [$filter, $dateNow])->get();
        $arrDetail = [];
        foreach ($orders as $key => $one) {
            if ($one->status_order == 3) {
                $orderDetail = DetailOrder::where("id_order", $one->id_order)->get();
                foreach ($orderDetail as $key => $detail) {
                    $name = $detail->name_product;
                    $quantity = $detail->quantity_product;
                    // Nếu sản phẩm đã tồn tại trong mảng $arrDetail
                    $existingKey = array_search($name, array_column($arrDetail, 'name')); //array_column: tao 1 mang moi chi co cot name
                    //existingKey se tra ve key dung
                    if ($existingKey !== false) {
                        // Tăng số lượng cho sản phẩm đã tồn tại
                        $arrDetail[$existingKey]['quantity'] += $quantity;
                    } else {
                        // Thêm sản phẩm mới vào mảng
                        $arrDetail[] = [
                            'name' => $name,
                            'quantity' => $quantity,
                            'exist' => $existingKey,
                        ];
                    }
                }
            }
        }
        // dd($arrDetail);
        return response()->json(['res' => 'success', 'arrDetail' => $arrDetail, 'from' => date('d-m-Y', strtotime($filter)), 'to' => date('d-m-Y', strtotime($dateNow))]);
    }

    function handleStatistic($order)
    {
        $date = date('Y-m-d', strtotime($order->updated_at));
        $id = $order->id_order;
        $statistic = Statistic::where('date_statistic', $date)->first();
        $detailOrder = DetailOrder::where('id_order', $id)->get();
        $quantityAll = 0;
        $totalAll = $order->total_order;
        foreach ($detailOrder as $key => $one) {
            $quantityAll += $one->quantity_product;
        }
        if ($statistic) {
            $quantityStatistic = $statistic->quantity_statistic + $quantityAll;
            $priceStatistic = $statistic->price_statistic + $totalAll;
            $statistic->quantity_statistic = $quantityStatistic;
            $statistic->price_statistic = $priceStatistic;
            $statistic->update();
        } else {
            $data = [
                'quantity_statistic' => $quantityAll,
                'price_statistic' => $totalAll,
                'date_statistic' => date('Y-m-d')
            ];
            Statistic::create($data);
        }
    }

    function handleOrderWithDB($idCustomer, $code, $order)
    {
        $noti = [];
        $handleIngredients = [];
        $carts = Cart::where('id_customer', $idCustomer)->get();
        foreach ($carts as $key => $one) {
            $handleIngredients[] = $this->handleIngredients($one['id_product'], $one['quantity_product']);
        }
        //xu ly loc cac san pham trung nhau de lay tong so luong nguyen lieu can dung 
        $sums = [];
        foreach ($handleIngredients as $item) {
            foreach ($item as $key => $value) {
                // Kiểm tra xem khóa đã tồn tại trong mảng tổng hay chưa
                if (!isset($sums[$key]['quantityProduct'])) {
                    $sums[$key]['quantityIngredient'] = $value['quantityIngredient']; // Giữ nguyên giá trị 'quantityIngredient'
                    $sums[$key]['quantityProduct'] = 0;
                }
                // Thực hiện cộng giá trị 'quantity' vào mảng tổng
                $sums[$key]['quantityProductBuy'][] = $value['quantityProductBuy']; //  so luong mua cua khach
                $sums[$key]['nameProduct'][] = $value['nameProduct']; // ten sp
                $sums[$key]['nameIngredient'][] = $value['nameIngredient']; // ten sp
                $sums[$key]['enoughProduct'][] = $value['enoughProduct']; // so luong du
                $sums[$key]['quantityProduct'] += $value['quantityProduct']; // so luong cong lai khi trung san pham
                $sums[$key]['totalIngredientOneProduct'][] = $value['quantityProduct']; // so luong khi lam ra san pham
                $sums[$key]['ingredientRecipeNeed'][] = $value['ingredientRecipeNeed']; // so luong nguyen lieu can trong cong thuc
            }
        }
        //tinh toan de dua ra lieu san pham co du khong
        $checkProduct = [];
        $isIngredients = true;
        foreach ($sums as $key => $sum) {
            if ($sum['quantityIngredient'] < $sum['quantityProduct']) {
                $quantityIngredient = $sum['quantityIngredient'];
                foreach ($sum['totalIngredientOneProduct'] as $index => $total) {
                    if (isset($sum['enoughProduct'][$index])) {
                        if ($quantityIngredient > $total) {
                            $quantityIngredient -= $total;
                        } else {
                            $quantityComsumptions = $quantityIngredient / $sum['ingredientRecipeNeed'][$index];
                            $isIngredients = false;
                            $checkProduct[] = [
                                'id' => $key,
                                'name' => $sum['nameProduct'][$index],
                                'nameIngredient' => $sum['nameIngredient'][$index],
                                'quantityComsumptions' => intval($quantityComsumptions),
                            ];
                            // break;
                        }
                    }
                }
            }
        }
        // dd($checkProduct);
        if (!$isIngredients) {
            $error = '<span class="d-block fs-20 text-left">Do có: </span>';
            $uniqueNames = [];
            foreach ($checkProduct as $key => $check) {
                $name = $check['name'];
                if (!in_array($name, $uniqueNames)) {
                    $uniqueNames[] = $name;
                    $error .= '<span class="text-danger text-left fs-18 d-block">+) Món ' . $name;
                } else {
                    $error .= ' và';
                }
                $error .= $check['quantityComsumptions'] ? ' chỉ còn đủ ' . $check['quantityComsumptions'] : ' không còn đủ ';
                $error .= ' sản phẩm do';
                $error .= $check['quantityComsumptions'] ? ' thiếu nguyên liệu ' . $check['nameIngredient'] : ' sản phẩm trên đã sử dụng hết ';
            }
            $error .= '</span>';
            $error .= '<span class="text-danger text-left fs-18 d-block">=> Cho nên sẽ không đặt được các sản phẩm còn lại </span>';
            $noti['status'] = $error;
        } else {
            $dataOrder = [
                'code_order' => $code,
                'id_customer' => $idCustomer,
                'name_order' => $order['fullname'],
                'phone_order' => $order['phone'],
                'address_order' => $order['address'],
                'email_order' => $order['email'],
                'subtotal_order' => $order['subtotal'],
                'fee_ship' => $order['fee_ship'],
                'fee_discount' => $order['fee_discount'],
                'total_order' => $order['total'],
                'email_order' => $order['email'],
                'status_order' => 0,
                'date_updated' => date('Y-m-d')
            ];
            // dd($dataOrder);
            $insertOrder = Order::create($dataOrder);
            $id = $insertOrder->id_order;
            foreach ($carts as $key => $one) {
                $dataDetailOrder = [
                    'id_order' => $id,
                    'code_order' => $code,
                    'id_product' => $one['id_product'],
                    'image_product' => $one['image_product'],
                    'name_product' => $one['name_product'],
                    'quantity_product' => $one['quantity_product'],
                    'price_product' => $one['price_product'],
                    'note_product' => $one['note_product'],
                ];
                $insertDetail = DetailOrder::create($dataDetailOrder);
                if ($insertDetail) {
                    Cart::where('id_customer', $idCustomer)->delete();
                    $noti += ['res' => 'success'];
                } else {
                    $noti += ['res' => 'fail'];
                }
                $this->handleGiftCoupon($order['subtotal'], $idCustomer); // tang ma khuyen mai
                if ($order['code_discount'] != '') {
                    $coupon = Coupon::where('code_coupon', $order['code_discount'])->first();
                    CustomerCoupon::where('id_customer', $idCustomer)->where('id_coupon', $coupon->id_coupon)->delete();
                }
            }
        }
        // dd($noti);
        return $noti;
    }

    function handleOrderWithSession($idCustomer, $code, $order, $cart)
    {
        $noti = [];

        foreach ($cart as $key => $one) {
            $handleIngredients = $this->handleIngredients($key, $one['quantity_product']);
        }
        //xu ly loc cac san pham trung nhau de lay tong so luong nguyen lieu can dung 
        $sums = [];
        foreach ($handleIngredients as $item) {
            foreach ($item as $key => $value) {
                // Kiểm tra xem khóa đã tồn tại trong mảng tổng hay chưa
                if (!isset($sums[$key]['quantityProduct'])) {
                    $sums[$key]['quantityIngredient'] = $value['quantityIngredient']; // Giữ nguyên giá trị 'quantityIngredient'
                    $sums[$key]['quantityProduct'] = 0;
                }
                // Thực hiện cộng giá trị 'quantity' vào mảng tổng
                $sums[$key]['quantityProductBuy'][] = $value['quantityProductBuy']; //  so luong mua cua khach
                $sums[$key]['nameProduct'][] = $value['nameProduct']; // ten sp
                $sums[$key]['nameIngredient'][] = $value['nameIngredient']; // ten sp
                $sums[$key]['enoughProduct'][] = $value['enoughProduct']; // so luong du
                $sums[$key]['quantityProduct'] += $value['quantityProduct']; // so luong cong lai khi trung san pham
                $sums[$key]['totalIngredientOneProduct'][] = $value['quantityProduct']; // so luong khi lam ra san pham
                $sums[$key]['ingredientRecipeNeed'][] = $value['ingredientRecipeNeed']; // so luong nguyen lieu can trong cong thuc
            }
        }
        //tinh toan de dua ra lieu san pham co du khong
        $checkProduct = [];
        $isIngredients = true;
        foreach ($sums as $key => $sum) {
            if ($sum['quantityIngredient'] < $sum['quantityProduct']) {
                $quantityIngredient = $sum['quantityIngredient'];
                foreach ($sum['totalIngredientOneProduct'] as $index => $total) {
                    if (isset($sum['enoughProduct'][$index])) {
                        if ($quantityIngredient > $total) {
                            $quantityIngredient -= $total;
                        } else {
                            $quantityComsumptions = $quantityIngredient / $sum['ingredientRecipeNeed'][$index];
                            $isIngredients = false;
                            $checkProduct[] = [
                                'id' => $key,
                                'name' => $sum['nameProduct'][$index],
                                'nameIngredient' => $sum['nameIngredient'][$index],
                                'quantityComsumptions' => intval($quantityComsumptions),
                            ];
                            // break;
                        }
                    }
                }
            }
        }
        if ($isIngredients) {
            $dataOrder = [
                'code_order' => $code,
                'id_customer' => $idCustomer,
                'name_order' => $order['fullname'],
                'phone_order' => $order['phone'],
                'subtotal_order' => $order['subtotal'],
                'fee_ship' => $order['fee_ship'],
                'fee_discount' => $order['fee_discount'],
                'address_order' => $order['address'],
                'total_order' => $order['total'],
                'email_order' => $order['email'],
                'status_order' => 0
            ];
            $insertOrder = Order::create($dataOrder);
            $id = $insertOrder->id_order;
            foreach ($cart as $key => $one) {
                $dataDetailOrder = [
                    'id_order' => $id,
                    'code_order' => $code,
                    'id_product' => $key,
                    'image_product' => $one['image_product'],
                    'name_product' => $one['name_product'],
                    'quantity_product' => $one['quantity_product'],
                    'price_product' => $one['price_product'],
                    'note_product' => $one['note_product'],
                ];
                $insertDetail = DetailOrder::create($dataDetailOrder);
                if ($insertDetail) {
                    $noti += ['res' => 'success'];
                } else {
                    $noti += ['res' => 'fail'];
                }
            }
        } else {
            $error = '<span class="d-block fs-20 text-left">Do có: </span>';
            $uniqueNames = [];
            foreach($checkProduct as $key => $check){
                $name = $check['name'];
                if (!in_array($name, $uniqueNames)) {
                    $uniqueNames[] = $name;
                    $error .= '<span class="text-danger text-left fs-18 d-block">+) Món ' . $name;
                }else{
                    $error .= ' và';
                }
                $error .= $check['quantityComsumptions'] ? ' chỉ còn đủ '.$check['quantityComsumptions'] : ' không còn đủ ';
                $error .= ' sản phẩm do';
                $error .= $check['quantityComsumptions'] ? ' thiếu nguyên liệu '.$check['nameIngredient'] : ' sản phẩm trên đã sử dụng hết ';
            }
            $error .= '</span>';
            $error .= '<span class="text-danger text-left fs-18 d-block">=> Cho nên sẽ không đặt được các sản phẩm còn lại </span>';
            $noti['status'] = $error;
        }
        return $noti;
    }

    function handleGiftCoupon($subtotal, $idCustomer)
    {
        $noti = [];
        $coupons = Coupon::where('expiration_time', '>=', date('Y-m-d'))->get();
        foreach ($coupons as $key => $coupon) {
            $subtotal = intval($subtotal);
            $isPrice = intval($coupon->is_price);
            $existCouponCustomer = CustomerCoupon::where('id_customer', $idCustomer)->where('id_coupon', $coupon->id_coupon)->first(); //ktra ton tai
            if (!$existCouponCustomer) {
                $dataCoupon = [
                    'id_customer' => $idCustomer,
                    'id_coupon' => $coupon->id_coupon,
                ];
                if ($subtotal >= $isPrice && $isPrice != 0) {
                    $insert = CustomerCoupon::create($dataCoupon);
                }
                $existOrder = Order::where('id_customer', $idCustomer)->get();
                $countOrder = count($existOrder);
                $isBuy = $coupon->is_buy;
                if ($countOrder == $isBuy && $isBuy != 0) {
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
                $nameIngredient = $ingredient->name_ingredient; //so luong nguyen lieu
                $quantityComponent = intval($one->quantity_recipe_need); // so luong cua thanh phan trong nguyen lieu
                $totalProduct = 0;
                $enoughProduct = 0;
                $quantityComponentConvert = 0;
                if ($abbreviationComponent == $abbreviationIngredient) { //ktra 2 don vi giong nhau k 
                    $quantityComponentConvert = $quantityComponent;
                    $totalProduct = $quantityComponent * $quantity; // tong so luong hien tai
                    $enoughProduct = intval($quantityIngredient / $quantityComponent);
                    $quantityComsumptions = $quantityIngredient - ($quantityComponent * $quantity); //so luong tieu thu
                } else {
                    $quantityComponentConvert = $this->convertUnit($quantityComponent, $abbreviationComponent, $abbreviationIngredient);
                    $totalProduct = $quantityComponentConvert * $quantity;
                    $enoughProduct = intval($quantityIngredient / $quantityComponentConvert);
                    $quantityComsumptions = $quantityIngredient - ($quantityComponentConvert * $quantity); //so luong tieu thu
                }
                $arrIngredients[$one->id_ingredient] = [
                    'nameProduct' => $name,
                    'nameIngredient' => $nameIngredient,
                    'quantityProduct' => $totalProduct,
                    'quantityIngredient' => $quantityIngredient,
                    'enoughProduct' => $enoughProduct,
                    'quantityProductBuy' => $quantity,
                    'ingredientRecipeNeed' => $quantityComponentConvert,
                ];
            }
            return $arrIngredients;
        }
    }

    function handlePushNotification($id, $code, $text, $textAdmin)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $server_key = 'AAAAgXdWpV8:APA91bGUQqgU3CDqRS5QfelSoyyG2-Az2nGiATnlyIC4xIxnNuanB-kN3ChySlL960sWObtceid2mUcK-Q3qIxx8CMJtYjx8nmSV6MtFp80AOdESpz1WgNJDWfpCFc1yEQZcN7zvbHaL';
        $message = array(
            "data" => array(
                'title' => 'Đơn hàng của bạn',
                'body' => $text,
                'icon' => "https://www.harper7coffee.com/images/favicon.ico",
                'click_action' => 'http://127.0.0.1:8000/page/order/detail/' . $code,
            ),
            'to'  => '/topics/' . $id,
        );
        // dd($message);

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $server_key,
            'Content-Type' => 'application/json',
        ])->post($url, $message);

        if ($response->failed()) {
            return "Error: " . $response->body();
        } else {
            $noti = [
                'id_account' => 0,
                'id_customer' => $id,
                'content' => $text,
                'link' => 'http://127.0.0.1:8000/page/order/detail/' . $code,
                'is_read' => 0,
            ];
            Notification::create($noti);
            $noti1 = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => $textAdmin,
                'link' => redirect()->route('order.adDetail', ['code' => $code])->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti1);
            return "Message sent successfully";
        }
    }
}
