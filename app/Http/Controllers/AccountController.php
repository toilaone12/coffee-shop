<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //
    function list(){
        $title = 'Danh sách tài khoản';
        $list = Account::all();
        $listRole = Role::all();
        return view('account.list',compact('title','list','listRole'));
    }

    function insert(Request $request){
        $data = $request->all();
        $otp = rand(100000,999999);
        $fullname = 'UID-'.rand(10000,99999);
        $titleMail = 'Tạo tài khoản thành công';
        $email = $data['email_account'];
        $username = $data['username_account'];
        $password = $data['password_account'];
        Validator::make($data,[
            'username_account' => ['required'],
            'password_account' => ['required', 'regex:/^[A-Za-z0-9]{6,32}+$/'],
            're_password_account' => ['required', 'same:password_account', 'regex:/^[A-Za-z0-9]{6,32}+$/'],
        ],[
            'username_account.required' => 'Vui lòng nhập tên tài khoản.',
            'password_account.required' => 'Vui lòng nhập mật khẩu.',
            're_password_account.required' => 'Vui lòng nhập lại mật khẩu.',
            're_password_account.same' => 'Mật khẩu và mật khẩu xác nhận không khớp.',
            '*.regex' => 'Mật khẩu chỉ được chứa chữ cái và số và phải từ 6 ký tự.',
        ])->validate();
        $checkEmail = Account::where('email_account',$email)->orWhere('username_account',$username)->first();
        if($checkEmail){
            return redirect()->route('account.list')->with('message','<span class="mx-3 text-success">Email của bạn đã tồn tại!</span>');
        }else{
            $dataMail = [
                'name' => $fullname,
                'username' => $username,
                'email' => $email,
                'otp' => $otp,
                'password' => $password
            ];
            $mail = Mail::send('mail.create',$dataMail,function($message) use ($titleMail,$email){
                $message->to($email)->subject($titleMail);
                $message->from($email,$titleMail);
            });
            if($mail == null){
                $db = [
                    'fullname_account' => $fullname,
                    'username_account' => $data['username_account'],
                    'email_account' => $data['email_account'],
                    'password_account' => md5($data['password_account']),
                    'id_role' => $data['id_role'],
                    'otp_account' => $otp,
                    'is_online' => 0,
                ];
                $insert = Account::create($db);
                if($insert){
                    return redirect()->route('account.list')->with('message','<span class="mx-3 mt-2 text-success">Đăng ký thành công, vui lòng kiểm tra email đã đăng ký</span>');
                }else{
                    return redirect()->route('account.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
                }
            }
        }
    }

    // function update(Request $request){
    //     $data = $request->all();
    //     $image = $request->file('image_product');
    //     $slug = Str::slug($data['name_product'], '-');
    //     $fileName = $slug . '-' . strtotime(now()) . '.jpg';
    //     $validator = Validator::make($data,[
    //         'image_product' => ['image','mimes:jpeg,png,jpg,gif'],
    //         'name_product' => ['required'],
    //         'quantity_product' => ['required'],
    //         'price_product' => ['required']
    //     ],[
    //         'image_product.required' => 'Vui lòng chọn một tệp ảnh.',
    //         'image_product.image' => 'Tệp phải là hình ảnh.',
    //         'image_product.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
    //         'name_product.required' => 'Tên của ảnh bắt buộc phải có',
    //         'quantity_product.required' => 'Số lượng sản phẩm bắt buộc phải có',
    //         'price_product.required' => 'Giá sản phẩm bắt buộc phải có',
    //     ]);
    //     if(!$validator->fails()){
    //         $pathStorage = 'storage/product/';
    //         if($image){
    //             $checkImageOriginal = Storage::disk('public')->exists('product/'.$data['image_original_product']);
    //             $image->storeAs('public/product', $fileName); // se luu vao storage/app
    //             if($checkImageOriginal){
    //                 Storage::disk('public')->delete('product/'.$data['image_original_product']);
    //             }
    //         }
    //         $product = Product::find($data['id_product']);
    //         $product->image_product = $image ? $pathStorage.$fileName : $pathStorage.$data['image_original_product'];
    //         $product->id_category = $data['id_category'];
    //         $product->name_product = $data['name_product'];
    //         $product->subname_product = $data['subname_product'];
    //         $product->quantity_product = $data['quantity_product'];
    //         $product->price_product = $data['price_product'];
    //         $product->description_product = $data['description_product'];
    //         $update = $product->save();
    //         if($update){
    //             return response()->json(['res' => 'success', 'status' => 'Thay đổi dữ liệu của sản phẩm về '.$data['name_product'].' thành công']);
    //         }else{
    //             return response()->json(['res' => 'fail', 'status' => 'Lỗi truy vấn dữ liệu']);
    //         }
    //     }else{
    //         return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
    //     }
    // }

    function delete(Request $request){
        $data = $request->all();
        $delete = Account::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }
}
