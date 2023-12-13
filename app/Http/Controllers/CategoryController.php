<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //
    function list(){
        $title = 'Danh sách danh mục';
        $list = Category::all();
        $listParent = Category::where('id_parent_category',0)->get();
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
        return view('category.list',compact('title','list','listParent','notifications','dot','all'));
    }

    function insert(Request $request){
        $data = $request->all();
        $slug = Str::slug($data['name_category'],'-');
        Validator::make($data,[
            'name_category' => ['required', 'regex:/^[\p{L}\s\p{P}]+$/u'],
        ],[
            'name_category.required' => 'Tên danh mục bắt buộc phải có',
            'name_category.regex' => 'Tên danh mục phải là chữ cái',
        ])->validate();
        $db = [
            'name_category' => $data['name_category'],
            'id_parent_category' => $data['id_parent_category'],
            'slug_category' => $slug,
        ];
        $insert = Category::create($db);
        if($insert){
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã thêm danh mục "'.$data['name_category'].'"',
                'link' => redirect()->route('category.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return redirect()->route('category.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('category.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request){
        $data = $request->all();
        $errors = [];
        if($data['name_category'] == ''){
            $errors['name'] = 'Tên danh mục bắt buộc phải có';
        }else if(!preg_match('/^[\p{L}\s\p{P}]+$/u',$data['name_category'])){
            $errors['name'] = 'Tên danh mục phải là chữ cái';
        }
        //neu cap nhat khong co loi 
        if(count($errors) == 0){
            $category = Category::find($data['id_category']);
            $name = $category->name_category;
            $category->name_category = $data['name_category'];
            $category->id_parent_category = $data['id_parent_category'];
            $category->slug_category = Str::slug($data['name_category'],'-');
            $update = $category->save();
            //neu cap nhat thanh cong
            if($update){
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã cập nhật từ "'.$name.'" thành "'.$data['name_category'].'"',
                    'link' => redirect()->route('category.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                return response()->json(['res' => 'success', 'title' => 'Sửa danh mục', 'icon' => 'success', 'status' => 'Thay đổi dữ liệu thành danh mục '.$data['name_category'].' thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Sửa danh mục', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $errors]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $category = Category::find($data['id']);
        $noti = [];
        //neu ton tai danh muc
        if($category){
            $name = $category->name_category;
            $idParent = $category->id_parent_category;
            $category->delete();
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa danh mục "'.$name.'"',
                'link' => redirect()->route('category.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            //neu la danh muc cha
            if($idParent == 0){
                $categoryChild = Category::where('id_parent_category',$category->id_category)->get();
                foreach($categoryChild as $child){
                    $deleteChild = $child->delete();
                    if($deleteChild){
                        $products = Product::where('id_category',$child->id_category)->get();
                        if(count($products) > 0){
                            foreach($products as $key => $product){
                                $deleteProduct = $product->delete();
                                if($deleteProduct){
                                    $recipe = Recipe::where('id_product',$product->id_product)->delete();
                                    $gallery = Gallery::where('id_product',$product->id_product)->delete();
                                    $review = Review::where('id_product',$product->id_product)->delete();
                                    $noti += ['res' => 'success'];
                                }else{
                                    $noti += ['res' => 'error'];
                                }
                            }
                        }else{
                            $noti += ['res' => 'success'];
                        }
                    }
                }
            
            }else{ //neu la danh muc con
                $products = Product::where('id_category',$data['id'])->get();
                if(count($products) > 0){
                    foreach($products as $key => $product){
                        $deleteProduct = $product->delete();
                        if($deleteProduct){
                            $recipe = Recipe::where('id_product',$product->id_product)->delete();
                            $gallery = Gallery::where('id_product',$product->id_product)->delete();
                            $review = Review::where('id_product',$product->id_product)->delete();
                            $noti += ['res' => 'success'];
                        }else{
                            $noti += ['res' => 'error'];
                        }
                    }
                }else{
                    $noti += ['res' => 'success'];
                }
            }
            if($noti['res'] == 'success'){
                return response()->json(['res' => 'success', 'title' => 'Xoá danh mục', 'icon' => 'success', 'status' => 'Xóa thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Xoá danh mục', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xoá danh mục', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $category = Category::where('id_category',$id)->first(); //tim danh muc dau 
            if($category){
                $name = $category->name_category;
                // dd($name);
                $category->delete(); //xoa danh muc dau
                $noti = [
                        'id_account' => request()->cookie('id_account'),
                        'id_customer' => 0,
                        'content' => 'Bạn đã xóa danh mục "' . $name . '"',
                        'link' => redirect()->route('category.list')->getTargetUrl(),
                        'is_read' => 0,
                    ];
                Notification::create($noti);
                $idParent = $category->id_parent_category; //ma cha 
                if($idParent == 0){  //neu la danh muc goc
                    $categoryChild = Category::where('id_parent_category',$category->id_category)->get(); // tim danh muc con
                    if(count($categoryChild) != 0){
                        foreach($categoryChild as $child){
                            $deleteChild = $child->delete(); //xoa danh muc con
                            if($deleteChild){
                                $products = Product::where('id_category',$child->id_category)->get(); //tim san pham cua danh muc con
                                if(count($products) > 0){ //neu co san pham
                                    foreach($products as $key => $product){
                                        $deleteProduct = $product->delete(); // xoa san pham
                                        if($deleteProduct){
                                            $recipe = Recipe::where('id_product',$product->id_product)->delete(); // xoa cong thuc
                                            $gallery = Gallery::where('id_product',$product->id_product)->delete(); // xoa danh muc hinh anh
                                            $review = Review::where('id_product',$product->id_product)->delete(); // xoa danh gia
                                            $noti += ['res' => 'success'];
                                        }else{
                                            $noti += ['res' => 'success'];
                                        }
                                    }
                                }else{
                                    $noti += ['res' => 'success'];
                                }
                            } else {
                                $noti += ['res' => 'success'];
                            }
                        }
                    }else{
                        $noti += ['res' => 'success'];
                    }
                }else{ //neu la danh muc con
                    $products = Product::where('id_category',$id)->get();
                    if(count($products) > 0){
                        foreach($products as $key => $product){
                            $deleteProduct = $product->delete();
                            if($deleteProduct){
                                $recipe = Recipe::where('id_product',$product->id_product)->delete();
                                $gallery = Gallery::where('id_product',$product->id_product)->delete();
                                $review = Review::where('id_product',$product->id_product)->delete();
                                $noti += ['res' => 'success'];
                            }else{
                                $noti += ['res' => 'success'];
                            }
                        }
                    }else{
                        $noti += ['res' => 'success'];
                    }
                }
            } else {
                $noti += ['res' => 'success'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success', 'title' => 'Xoá danh mục', 'icon' => 'success', 'status' => 'Xóa thành công']);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Xoá danh mục', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    //page 
    function home($parent, $child){
        $category = Category::where('slug_category',$child)->first();
        $lists = Product::where('id_category',$category->id_category)->get();
        $title = $category->name_category;
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        $carts = array();
        $notifications = array();
        $isDot = '';
        if(request()->cookie('id_customer')){
            $carts = Cart::where('id_customer',request()->cookie('id_customer'))->get();
            $notifications = Notification::where('id_customer', request()->cookie('id_customer'))->orderBy('id_notification','desc')->limit(7)->get();
            $isDot = Notification::where('id_customer', request()->cookie('id_customer'))->where('is_read',0)->orderBy('id_notification','desc')->get();
        }
        $arrayProductInCategory = [];
        foreach($childCategorys as $key => $child){
            $productChild = Product::where('id_category',$child->id_category)->get();
            $parent = Category::where('id_category',$child->id_parent_category)->first();
            $count = count($productChild);
            $array = [
                'id_category' => $child->id_category,
                'name_category' => $child->name_category,
                'slug_parent' => $parent->slug_category,
                'slug_child' => $child->slug_category,
                'number_product' => $count,
            ];
            array_push($arrayProductInCategory, $array);
        }
        // dd($arrayProductInCategory);
        $listChilds = collect($arrayProductInCategory);
        return view('category.home',compact('lists','title','parentCategorys','childCategorys','listChilds','carts','notifications','isDot'));
    }

    function search(Request $request){
        $title = 'Tìm kiếm';
        $data = $request->all();
        Validator::make($data,[
            'keyword' => ['required']
        ],
        [
            'keyword.required' => 'Thông tin tìm kiếm bạn phải điền',
        ])->validate();
        $keyword = $data['keyword'];
        $lists = Product::where('name_product','like','%'.$keyword.'%')->get();
        $parentCategorys = Category::where('id_parent_category',0)->get();
        $childCategorys = Category::where('id_parent_category','!=',0)->get();
        $arrayProductInCategory = [];
        foreach($childCategorys as $key => $child){
            $productChild = Product::where('id_category',$child->id_category)->get();
            $parent = Category::where('id_category',$child->id_parent_category)->first();
            $count = count($productChild);
            $array = [
                'id_category' => $child->id_category,
                'name_category' => $child->name_category,
                'slug_parent' => $parent->slug_category,
                'slug_child' => $child->slug_category,
                'number_product' => $count,
            ];
            array_push($arrayProductInCategory, $array);
        }
        // dd($arrayProductInCategory);
        $listChilds = collect($arrayProductInCategory);
        return view('category.home',compact('lists','title','parentCategorys','childCategorys','listChilds'));
    }
}
