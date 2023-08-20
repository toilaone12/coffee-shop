<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    function dashboard() {
        $title = 'Trang chủ';
        return view('admin.content', compact('title'));
    }
}
