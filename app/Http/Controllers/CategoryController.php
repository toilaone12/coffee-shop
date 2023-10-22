<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    function list(){
        $title = 'Danh sách danh mục';
        $list = Category::all();
        $listParent = Category::where('id_parent_category',0)->get();
        return view('category.list',compact('title','list','listParent'));
    }

    function insert(Request $request){
        $data = $request->all();
        Validator::make($data,[
            'name_category' => ['required', 'regex:/^[\p{L}\s\p{P}]+$/u'],
        ],[
            'name_category.required' => 'Tên danh mục bắt buộc phải có',
            'name_category.regex' => 'Tên danh mục phải là chữ cái',
        ])->validate();
        $db = [
            'name_category' => $data['name_category'],
            'id_parent_category' => $data['id_parent_category'],
        ];
        $insert = Category::create($db);
        if($insert){
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
        if(count($errors) == 0){
            $category = Category::find($data['id_category']);
            $category->name_category = $data['name_category'];
            $category->id_parent_category = $data['id_parent_category'];
            $update = $category->save();
            if($update){
                return response()->json(['res' => 'success', 'status' => 'Thay đổi dữ liệu thành danh mục '.$data['name_category'].' thành công']);
            }else{
                return response()->json(['res' => 'fail', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $errors]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $category = Category::find($data['id']);
        $noti = [];
        if($category){
            $idParent = $category->id_parent_category;
            $category->delete();
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
                                    if($recipe || $gallery || $review){
                                        $noti += ['res' => 'success'];
                                    }else{
                                        $noti += ['res' => 'error'];
                                    }
                                }else{
                                    $noti += ['res' => 'error'];
                                }
                            }
                        }else{
                            $noti += ['res' => 'success'];
                        }
                    }
                }
            }else{
                $products = Product::where('id_category',$data['id'])->get();
                if(count($products) > 0){
                    foreach($products as $key => $product){
                        $deleteProduct = $product->delete();
                        if($deleteProduct){
                            $recipe = Recipe::where('id_product',$product->id_product)->delete();
                            $gallery = Gallery::where('id_product',$product->id_product)->delete();
                            $review = Review::where('id_product',$product->id_product)->delete();
                            if($recipe || $gallery || $review){
                                $noti += ['res' => 'success'];
                            }else{
                                $noti += ['res' => 'error'];
                            }
                        }else{
                            $noti += ['res' => 'error'];
                        }
                    }
                }else{
                    $noti += ['res' => 'success'];
                }
            }
            if($noti['res'] == 'success'){
                return response()->json(['res' => 'success'],200);
            }else{
                return response()->json(['res' => 'fail'],200);
            }
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $category = Category::where('id_category',$id)->first(); //tim danh muc dau 
            $idParent = $category->id_parent_category; //ma cha 
            $category->delete(); //xoa danh muc dau
            if($idParent == 0){  //neu la danh muc goc
                $categoryChild = Category::where('id_parent_category',$category->id_category)->get(); // tim danh muc con
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
                                    if($recipe || $gallery || $review){
                                        $noti += ['res' => 'success'];
                                    }else{
                                        $noti += ['res' => 'error'];
                                    }
                                }else{
                                    $noti += ['res' => 'error'];
                                }
                            }
                        }else{
                            $noti += ['res' => 'success'];
                        }
                    }
                }
            }else{
                $products = Product::where('id_category',$id)->get();
                if(count($products) > 0){
                    foreach($products as $key => $product){
                        $deleteProduct = $product->delete();
                        if($deleteProduct){
                            $recipe = Recipe::where('id_product',$product->id_product)->delete();
                            $gallery = Gallery::where('id_product',$product->id_product)->delete();
                            $review = Review::where('id_product',$product->id_product)->delete();
                            if($recipe || $gallery || $review){
                                $noti += ['res' => 'success'];
                            }else{
                                $noti += ['res' => 'error'];
                            }
                        }else{
                            $noti += ['res' => 'error'];
                        }
                    }
                }else{
                    $noti += ['res' => 'success'];
                }
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    //page 
    function home($parent, $name){
        $title = $name;
        $lists = Category::where('name_category',$name)->get();
        dd($lists);
        return view('category.home', compact('title','name','lists'));
    }
}
