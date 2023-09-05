<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    function list(){
        $title = 'Danh sách đơn hàng';
        $list = Order::all();
        return view('order.list',compact('title','list'));
    }
}
