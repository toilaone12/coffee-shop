<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeeController extends Controller
{
    //admin
    function list(){
        $title = 'Danh sách phương thức';
        $list = Fee::all();
        return view('fee.list',compact('title','list'));
    }

    function insert(Request $request){
        $data = $request->all();
        Validator::make($data,[
            'fee' => ['required'],
        ],[
            'fee.required' => 'Phí vận chuyển bắt buộc phải có',
        ])->validate();
        $db = [
            'radius_fee' => $data['radius_fee'],
            'weather_condition' => $data['weather_condition'],
            'fee' => $data['fee'],
        ];
        $insert = Fee::create($db);
        if($insert){
            return redirect()->route('fee.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('fee.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request){
        $data = $request->all();
        $validation = Validator::make($data,[
            'fee' => ['required'],
        ],[
            'fee.required' => 'Phí vận chuyển bắt buộc phải có',
        ]);
        if(!$validation->fails()){
            $fee = Fee::find($data['id_fee']);
            $fee->radius_fee = $data['radius_fee'];
            $fee->weather_condition = $data['weather_condition'];
            $fee->fee = $data['fee'];
            $update = $fee->save();
            if($update){
                return response()->json(['res' => 'success', 'title'=> 'Sửa phí vận chuyển', 'icon' => 'success', 'status' => 'Thay đổi dữ liệu thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title'=> 'Sửa phí vận chuyển', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $delete = Fee::find($data['id'])->delete();
        if($delete){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $delete = Fee::where('id_fee',$id)->delete();
            if($delete){
                $noti += ['res' => 'success'];
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success'],200);
        }else{
            return response()->json(['res' => 'fail'],200);
        }
    }

    //page
    //tra phi
    function search(Request $request){
        $data = $request->all();
        $address = $data['address_fee'];
        $distance = $this->getDistance($address);
        dd($distance);
    }

    function getDistance($address) {
        $apiKey = 'X5rp4KMjYtFLZvjKBlRWIGh_BKUecHaGUQ8sGwkOOT4';
        $url = "https://geocode.search.hereapi.com/v1/geocode?q=" . urlencode($address) . "&apiKey=" . $apiKey;
        
        // Gửi yêu cầu HTTP GET và lấy kết quả
        $response = file_get_contents($url);
        
        // Xử lý kết quả JSON
        $data = json_decode($response, true);
        
        // Lấy tọa độ từ kết quả
        return $data;
        $coordinates = $data['Response']['View'][0]['Result'][0]['Location']['DisplayPosition'];
    }
}
