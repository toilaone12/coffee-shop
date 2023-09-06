<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    function list(){
        $title = 'Danh sách đánh giá';
        $list = Review::all();
        return view('review.list',compact('title','list'));
    }
}
