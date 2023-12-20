<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    function list(){
        $title = 'Danh sách sản phẩm';
        $list = Product::all();
        $listCate = Category::all();
        $notifications = Notification::where('id_account',request()->cookie('id_account'))->orderBy('id_notification','desc')->limit(7)->get();
        $all = Notification::where('id_account',request()->cookie('id_account'))->get();
        $dot = false;
        foreach($all as $noti){
            if($noti->is_read == 0){
                $dot = true;
            }else{
                $dot = false;
            }
        }
        // dd($listCate);
        return view('product.list',compact('title','list','listCate','notifications','dot'));
    }

    function insert(Request $request){
        $data = $request->all();
        $image = $request->file('image_product');
        $slug = Str::slug($data['name_product'], '-');
        $fileName = $slug . '-' . strtotime(now()) . '.jpg';
        Validator::make($data,[
            'image_product' => ['required','image','mimes:jpeg,png,jpg,gif'],
            'name_product' => ['required'],
            'price_product' => ['required'],
            'is_special' => ['required']
        ],[
            'image_product.required' => 'Vui lòng chọn một tệp ảnh.',
            'image_product.image' => 'Tệp phải là hình ảnh.',
            'image_product.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
            'name_product.required' => 'Tên của ảnh bắt buộc phải có',
            'price_product.required' => 'Giá sản phẩm bắt buộc phải có',
            'is_special.required' => 'Lựa chọn món bestseller bắt buộc phải có',
        ])->validate();
        $image->storeAs('public/product', $fileName); // se luu vao storage/app/product va storage/product tren folder public
        $db = [
            'id_category' => $data['id_category'],
            'image_product' => 'storage/product/'.$fileName,
            'name_product' => $data['name_product'],
            'subname_product' => $data['subname_product'],
            'price_product' => $data['price_product'],
            'description_product' => $data['description_product'],
            'is_special' => $data['is_special'],
            'slug_product' => $slug
        ];
        $insert = Product::create($db);
        if($insert){
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã thêm sản phẩm "'.$data['name_product'].'"',
                'link' => redirect()->route('product.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return redirect()->route('product.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('product.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request){
        $data = $request->all();
        $image = $request->file('image_product');
        $slug = Str::slug($data['name_product'], '-');
        $fileName = $slug . '-' . strtotime(now()) . '.jpg';
        $validator = Validator::make($data,[
            'image_product' => ['image','mimes:jpeg,png,jpg,gif'],
            'name_product' => ['required'],
            'price_product' => ['required']
        ],[
            'image_product.required' => 'Vui lòng chọn một tệp ảnh.',
            'image_product.image' => 'Tệp phải là hình ảnh.',
            'image_product.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
            'name_product.required' => 'Tên của ảnh bắt buộc phải có',
            'price_product.required' => 'Giá sản phẩm bắt buộc phải có',
        ]);
        if(!$validator->fails()){
            $pathStorage = 'storage/product/';
            if($image){
                $checkImageOriginal = Storage::disk('public')->exists('product/'.$data['image_original_product']);
                $image->storeAs('public/product', $fileName); // se luu vao storage/app
                if($checkImageOriginal){
                    Storage::disk('public')->delete('product/'.$data['image_original_product']);
                }
            }
            $product = Product::find($data['id_product']);
            $name = $product->name_product;
            $product->image_product = $image ? $pathStorage.$fileName : $pathStorage.$data['image_original_product'];
            $product->id_category = $data['id_category'];
            $product->name_product = $data['name_product'];
            $product->slug_product = $slug;
            $product->subname_product = $data['subname_product'];
            $product->price_product = $data['price_product'];
            $product->description_product = $data['description_product'];
            $product->is_special = $data['is_special'];
            $update = $product->save();
            if($update){
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã cập nhật từ "'.$name.'" thành "'.$data['name_product'].'"',
                    'link' => redirect()->route('product.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                return response()->json(['res' => 'success', 'title' => 'Sửa sản phẩm', 'icon' => 'success', 'status' => 'Thay đổi dữ liệu của sản phẩm về '.$data['name_product'].' thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Sửa sản phẩm', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $product = Product::find($data['id']);
        if($product){
            $name = $product->name_product;
            $product->delete();
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa sản phẩm"'.$name.'"',
                'link' => redirect()->route('product.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            $review = Review::where('id_product',$data['id'])->delete();
            $recipe = Recipe::where('id_product',$data['id'])->delete();
            $gallery = Gallery::where('id_product',$data['id'])->delete();
            return response()->json(['res' => 'success', 'title' => 'Xoá sản phẩm', 'icon' => 'success', 'status' => 'Xóa thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xoá sản phẩm', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $product = Product::where('id_product',$id)->first();
            if($product){
                $name = $product->name_product;
                $product->delete();
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã xóa sản phẩm "'.$name.'"',
                    'link' => redirect()->route('product.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                $review = Review::where('id_product',$id)->delete();
                $recipe = Recipe::where('id_product',$id)->delete();
                $gallery = Gallery::where('id_product',$id)->delete();
                $noti += ['res' => 'success'];
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success', 'title' => 'Xoá sản phẩm', 'icon' => 'success', 'status' => 'Xóa thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xoá sản phẩm', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    //page 
    function detail($slug){
        $product = Product::where('slug_product',$slug)->first();
        if($product){
            $title = $product->name_product;
            $parentCategorys = Category::where('id_parent_category',0)->get();
            $childCategorys = Category::where('id_parent_category','!=',0)->get();
            $relates = Product::where('id_category',$product->id_category)->limit(4)->get();
            $reviews = Review::where('id_product',$product->id_product)->orderBy('id_review','desc')->get();
            $gallerys = Gallery::where('id_product',$product->id_product)->limit(4)->get();
            $carts = array();
            $isDot = '';
            $customer = '';
            $notifications = array();
            if(request()->cookie('id_customer')){
                $customer = Customer::find(request()->cookie('id_customer'));
                $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
                $notifications = Notification::where('id_customer', request()->cookie('id_customer'))->orderBy('id_notification','desc')->limit(7)->get();
                $isDot = Notification::where('id_customer', request()->cookie('id_customer'))->where('is_read',0)->orderBy('id_notification','desc')->get();
            }
            return view('product.home',compact('customer','product','title','parentCategorys','childCategorys','carts','relates','reviews','gallerys','notifications','isDot'));
        }else{
            return redirect()->route('page.home');
        }
    }

    function menu(){
        $products = Product::all();
        $title = 'Menu';
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        $carts = array();
        $customer = '';
        $isDot = '';
        $notifications = array();
        if(request()->cookie('id_customer')){
            $customer = Customer::find(request()->cookie('id_customer'));
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
            $notifications = Notification::where('id_customer', request()->cookie('id_customer'))->orderBy('id_notification','desc')->limit(7)->get();
            $isDot = Notification::where('id_customer', request()->cookie('id_customer'))->where('is_read',0)->orderBy('id_notification','desc')->get();
        }
        return view('product.menu',compact('customer','products','title','parentCategorys','childCategorys','carts','notifications','isDot'));
    }
}
