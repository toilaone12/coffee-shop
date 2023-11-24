@extends('dashboard')
@section('content')
@if($order->status_order == 0)
<style>
  #progressbar-2 li:nth-child(1):after {
    left: 1%;
    width: 100%;
    background: #c5cae9 !important;
    /* Màu mặc định */
  }
</style>
@elseif($order->status_order == 1)
<style>
  #progressbar-2 li:nth-child(2):after {
    left: 1%;
    width: 100%;
    background: #c5cae9 !important;
    /* Màu mặc định */
  }
</style>
@elseif($order->status_order == 2)
<style>
  #progressbar-2 li:nth-child(3):after {
    left: 1%;
    width: 100%;
    background: #c5cae9 !important;
    /* Màu mặc định */
  }
</style>
@else
<style>
  #progressbar-2 li:nth-child(1):after,
  #progressbar-2 li:nth-child(2):after,
  #progressbar-2 li:nth-child(3):after,
  #progressbar-2 li:nth-child(4):after {
    left: 0%;
    width: 100%;
  }
</style>
@endif
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <ul id="progressbar-2" class="d-flex justify-content-between mx-0 mt-0 pt-0 pb-lg-2 pb-md-2 pb-ssm-0">
            @if($order->status_order != 4)
            <li class="active text-center" id="step1"></li>
            <li class="step0 {{$order->status_order >= 1 ? 'active' : ''}} text-center" id="step2"></li>
            <li class="step0 {{$order->status_order >= 2 ? 'active' : ''}} text-center" id="step3"></li>
            <li class="step0 {{$order->status_order >= 3 ? 'active' : ''}} text-muted text-end" id="step4"></li>
            @else
            <li class="cancel text-center w-100" id="step1"></li>
            <li class="step0 d-none text-center" id="step2"></li>
            <li class="step0 d-none text-center" id="step3"></li>
            <li class="step0 cancel text-danger text-muted text-end" id="step5"></li>
            @endif
        </ul>
        @if($order->status_order == 4)
        <div class="d-flex justify-content-between">
            <div class="d-lg-flex">
                <div>
                    <p class="fs-bold status-order">Đơn hàng</p>
                </div>
            </div>
            <div class="d-lg-flex">
                <div>
                    <p class="fs-bold" style="padding-left: 23px"></p>
                </div>
            </div>
            <div class="d-lg-flex">
                <div>
                    <p class="fs-bold mb-0"></p>
                </div>
            </div>
            <div class="d-lg-flex">
                <div>
                    <p class="fs-bold mb-0 mr-lg-3 mr-ssm-0 status-cancel">Đã hủy đơn</p>
                </div>
            </div>
        </div>
        @else
        <div class="d-flex justify-content-between">
            <div class="d-lg-flex">
                <div>
                    <p class="fs-bold status-wait">Đặt đơn</p>
                </div>
            </div>
            <div class="d-lg-flex">
                <div>
                    <p class="fs-bold status-accept">Nhận đơn</p>
                </div>
            </div>
            <div class="d-lg-flex">
                <div>
                    <p class="fs-bold mb-0 status-journey">Giao hàng</p>
                </div>
            </div>
            <div class="d-lg-flex">
                <div>
                    <p class="fs-bold mb-0 status-success">Thành công</p>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Chi tiết đơn hàng #{{$order->code_order}} <span class="id-order d-none">{{$order->id_order}}</span></h3>
                    </div>
                    <div class="card-body">
                        <div class="border-bottom pb-3">
                            <div class="fs-15 text-dark mb-2">
                                Họ tên người đặt: {{ucwords($order->name_order)}}
                            </div>
                            <div class="fs-15 text-dark d-flex mb-2 align-items-center">
                                Số điện thoại: <span class="phone-customer ml-1">{{$order->phone_order}}</span>
                                <div class="ml-3">
                                    <button class="btn btn-primary call-customer">
                                        <i class="fa-solid fa-phone"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="fs-15 text-dark mb-2">
                                Địa chỉ giao hàng: {{ucwords($order->address_order)}}
                            </div>
                        </div>
                        <div class="mt-3">
                            <table id="myTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã đơn</th>
                                        <th>Hình ảnh sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng mua</th>
                                        <th>Giá cả</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $key => $one)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td class="code">{{$one->code_order}}</td>
                                        <td class="image">
                                            <img loading="lazy" src="{{ asset($one->image_product) }}" class="image" width="120" height="120" alt="" srcset="">
                                        </td>
                                        <td class="name">{{$one->name_product}}</td>
                                        <td class="quantity">{{$one->quantity_product}}</td>
                                        <td class="price">{{$one->price_product}}</td>
                                        <td class="note">{{$one->note_product ? $one->note_product : 'Không có'}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-3 ">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="card">
                            <h5 class="card-header">Cài đặt</h5>
                            <div class="card-body">
                                <a href="{{route('order.export')}}" class="btn btn-primary w-100">In hóa đơn</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-sm-12 mt-3">
                        <div class="card">
                            <h5 class="card-header">Thay đổi trạng thái đơn hàng</h5>
                            <div class="card-body">
                                @foreach($listStatus as $key => $status)
                                <a href="{{route('order.change',['id' => $order->id_order,'status' => $key])}}" class="w-100 btn btn-primary d-block {{$key > 1 ? 'mt-3': ''}} {{$key == $order->status_order || $key != intval($order->status_order) + 1 ? 'disabled' : ''}}">{{$status}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->

</div>
@endsection