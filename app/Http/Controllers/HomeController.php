<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\News;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    //
    function home (){
        $title = 'Trang chủ';
        $slides = Slide::all();
        $products = Product::where('is_special',1)->orderBy('id_product','desc')->get();
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        $news = News::orderBy('updated_at', 'desc')->get();
        $carts = array();
        $notifications = array();
        $customer = '';
        $isDot = '';
        if(request()->cookie('id_customer')){
            $customer = Customer::find(request()->cookie('id_customer'));
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
            $notifications = Notification::where('id_customer', request()->cookie('id_customer'))->orderBy('id_notification','desc')->limit(7)->get();
            $isDot = Notification::where('id_customer', request()->cookie('id_customer'))->where('is_read',0)->orderBy('id_notification','desc')->get();
        }
        return view('home.content',compact(
            'title',
            'slides',
            'products',
            'parentCategorys',
            'childCategorys',
            'news',
            'carts',
            'notifications',
            'isDot',
            'customer'
        ));
    }
}
