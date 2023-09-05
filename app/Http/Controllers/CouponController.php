<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //
    function list(){
        $title = "Danh sách mã khuyến mãi";
        $list = Coupon::all();
        return view('coupon.list',compact('title','list'));
    }
}
