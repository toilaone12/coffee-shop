<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    function home (){
        $title = 'Trang chủ';
        return view('page',compact('title'));
    }
}
