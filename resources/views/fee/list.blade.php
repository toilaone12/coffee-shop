@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách phí vận chuyển</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Bán kính</th>
                                    <th>Thời tiết</th>
                                    <th>Phí vận chuyển (Tính km)</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" value="{{$one->id_fee}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="radius-{{$one->id_fee}}">{{$one->radius_fee}} km</td>
                                    <td class="weather-{{$one->id_fee}}">{{$one->weather_condition}}</td>
                                    <td class="fee-{{$one->id_fee}}">{{number_format($one->fee,0,',','.')}}đ</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary update-fee-{{$one->id_fee}} fee" 
                                            data-id="{{$one->id_fee}}" 
                                            data-toggle="modal" 
                                            data-target="#updateModal"
                                            >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger delete-fee" data-id="{{$one->id_fee}}"><i class="fa-solid fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-3 ">
                <div class="card">
                    <h5 class="card-header">Thao tác chung</h5>
                    <div class="card-body">
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Thêm phí</button>
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-fee d-block mb-3">Xóa nhiều</button>
                        <button class="w-100 btn btn-primary choose-all d-block">Chọn nhiều</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Insert -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm phí vận chuyển</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('fee.insert')}}" method="post">
                    @csrf
                    <?php
                    use Illuminate\Support\Facades\Session;
                    $message = Session::get('message');
                    if(isset($message)){
                        echo $message;
                        Session::put('message','');
                    }
                    ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="radius">Bán kính (<span class="radius-fee">3</span> km)</label>
                                    <input type="range" min=0 max=10 step="1" value="3" name="radius_fee" id="radius" class="custom-range range-radius">
                                    @error('radius_fee')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="weather">Thời tiết</label>
                                    <select name="weather_condition" class="form-control" id="weather">
                                        <option value="Sun">Nắng</option>
                                        <option value="Rain">Mưa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fee">Phí vận chuyển</label>
                            <input type="number" min=0 name="fee" id="fee" class="form-control">
                            @error('fee')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- Modal Update -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa phương thức thanh toán</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="update-fee">
                    <div class="modal-body">
                        <input type="hidden" name="id_fee" class="id-fee">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="radius">Bán kính (<span class="radius-fee">3</span> km)</label>
                                    <input type="range" min=0 max=10 step="1" value="3" name="radius_fee" id="radius" class="custom-range range-radius radius-update">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="weather">Thời tiết</label>
                                    <select name="weather_condition" class="form-control weather-update" id="weather">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fee">Phí vận chuyển</label>
                            <input type="number" min=0 name="fee" id="fee" class="form-control fee-update">
                            <span class="text-danger error-fee"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- End of Main Content -->

</div>
@endsection