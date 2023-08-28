<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    function list(){
        $title = 'Danh sách khách hàng';
        $list = Customer::all();
        return view('customer.list',compact('title','list'));
    }
}
