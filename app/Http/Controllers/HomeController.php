<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    function home (){
        $title = 'Trang chủ';
        $slides = Slide::all();
        $products = Product::all();
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        $news = News::orderBy('updated_at', 'desc')->get();
        return view('home.content',compact(
            'title',
            'slides',
            'products',
            'parentCategorys',
            'childCategorys',
            'news'
        ));
    }
}
