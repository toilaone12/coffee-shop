<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeeController extends Controller
{
    //admin
    function list()
    {
        $title = 'Danh sách phương thức';
        $list = Fee::all();
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
        return view('fee.list', compact('title', 'list','notifications','dot'));
    }

    function insert(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'fee' => ['required'],
        ], [
            'fee.required' => 'Phí vận chuyển bắt buộc phải có',
        ])->validate();
        $db = [
            'radius_fee' => $data['radius_fee'],
            'weather_condition' => $data['weather_condition'],
            'fee' => $data['fee'],
        ];
        $insert = Fee::create($db);
        if ($insert) {
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã thêm phí vận chuyển cho bán kính "'.$data['radius_fee'].' km" với điều kiện "'.$data['weather_condition'].'"',
                'link' => redirect()->route('fee.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return redirect()->route('fee.list')->with('message', '<span class="mx-3 text-success">Thêm thành công</span>');
        } else {
            return redirect()->route('fee.list')->with('message', '<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request)
    {
        $data = $request->all();
        $validation = Validator::make($data, [
            'fee' => ['required'],
        ], [
            'fee.required' => 'Phí vận chuyển bắt buộc phải có',
        ]);
        if (!$validation->fails()) {
            $fee = Fee::find($data['id_fee']);
            $fee->radius_fee = $data['radius_fee'];
            $fee->weather_condition = $data['weather_condition'];
            $fee->fee = $data['fee'];
            $update = $fee->save();
            if ($update) {
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã cập nhật lại phí vận chuyển cho bán kính "'.$data['radius_fee'].' km" với điều kiện "'.$data['weather_condition'].'"',
                    'link' => redirect()->route('fee.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                return response()->json(['res' => 'success', 'title' => 'Sửa phí vận chuyển', 'icon' => 'success', 'status' => 'Thay đổi dữ liệu thành công']);
            } else {
                return response()->json(['res' => 'fail', 'title' => 'Sửa phí vận chuyển', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        } else {
            return response()->json(['res' => 'warning', 'status' => $validation->errors()]);
        }
    }

    function delete(Request $request)
    {
        $data = $request->all();
        $fee = Fee::find($data['id']);
        if ($fee) {
            $name = $fee->radius_fee;
            $condition = $fee->weather_condition;
            $fee->delete();
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa phí vận chuyển với bán kính "'.$name.'" với điều kiện "'.$condition.'"',
                'link' => redirect()->route('fee.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return response()->json(['res' => 'success', 'title' => 'Xóa phí vận chuyển', 'icon' => 'success', 'status' => 'Xóa thành công']);
        } else {
            return response()->json(['res' => 'fail', 'title' => 'Xóa phí vận chuyển', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    function deleteAll(Request $request)
    {
        $data = $request->all();
        $noti = [];
        foreach ($data['arrId'] as $key => $id) {
            $fee = Fee::where('id_fee', $id)->first();
            if ($fee) {
                $name = $fee->radius_fee;
                $condition = $fee->weather_condition;
                $fee->delete();
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã xóa phí vận chuyển với bán kính "'.$name.'" với điều kiện "'.$condition.'"',
                    'link' => redirect()->route('fee.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                $noti += ['res' => 'success'];
            } else {
                $noti += ['res' => 'fail'];
            }
        }
        if ($noti['res'] == 'success') {
            return response()->json(['res' => 'success', 'title' => 'Xóa phí vận chuyển', 'icon' => 'success', 'status' => 'Xóa thành công']);
        } else {
            return response()->json(['res' => 'fail', 'title' => 'Xóa phí vận chuyển', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    //page
    //tra phi
    function search(Request $request)
    {
        $data = $request->all();
        $apiKey = 'M--tqWacqVfZvRoIjEeEN9Pn_nPJV6IHlRPHaQBUN3M';
        $lat = $data['lat_fee'];
        $lng = $data['lng_fee'];
        $start = '20.993961580653178,105.79290252525247';
        $end = $lat . ',' . $lng;
        $endpoint = 'https://router.hereapi.com/v8/routes';
        $url = $endpoint . '?xnlp=CL_JSMv3.1.38.0&apikey=' . $apiKey . '&routingMode=fast&transportMode=car&origin=' . $start . '&destination=' . $end . '&return=travelSummary';
        // return $url;
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $distance = $data['routes'][0]['sections'][0]['travelSummary']['length'] / 1000;
        $weather = $this->getStatusWeather($lat, $lng);
        $arrayWeather = ['Clouds', 'Rain', 'Drizzle', 'Thunderstorm', 'Snow'];
        $condition = '';
        if (array_search($weather, $arrayWeather)) {
            $condition = 'Rain';
        } else {
            $condition = 'Sun';
        }
        // DB::enableQueryLog();
        $checkFee = Fee::where('weather_condition', $condition)->where('radius_fee', '>=', $distance)->orderBy('radius_fee', 'asc')->first();
        // dd(DB::getQueryLog());
        // dd($url);
        if ($checkFee) {
            return response()->json(['res' => 'success', 'fee' => $checkFee->fee]);
        } else {
            if ($condition == 'Rain') {
                return response()->json(['res' => 'success', 'weather' => $condition, 'fee' => 5000 * round($distance)]);
            } else {
                return response()->json(['res' => 'success', 'weather' => $condition, 'fee' => 3000 * round($distance)]);
            }
        }
        // return array('distance' => $distance, 'duration' => $duration);
    }

    function getDistance($address)
    {
        $apiKey = 'X5rp4KMjYtFLZvjKBlRWIGh_BKUecHaGUQ8sGwkOOT4';
        $url = "https://geocode.search.hereapi.com/v1/geocode?q=" . urlencode($address) . "&apiKey=" . $apiKey;

        // Gửi yêu cầu HTTP GET và lấy kết quả
        $response = file_get_contents($url);

        // Xử lý kết quả JSON
        $data = json_decode($response, true);

        // Lấy tọa độ từ kết quả
        return $data;
    }

    function getStatusWeather($lat, $lng)
    {
        $apiKey = '69f59d0621e668fb571e5dda73e6ab46';
        $url = 'https://api.openweathermap.org/data/2.5/weather?lat=' . $lat . '&lon=' . $lng . '&appid=' . $apiKey;
        $response = file_get_contents($url);

        // Xử lý kết quả JSON
        $data = json_decode($response, true);
        return $data['weather'][0]['main'];
    }
}
