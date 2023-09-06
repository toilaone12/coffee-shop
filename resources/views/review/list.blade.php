@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-12 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách đơn hàng</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Tên người đánh giá</th>
                                    <th>Nội dung đánh giá</th>
                                    <th>Số sao đánh giá</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" value="{{$one->id_review}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="name-{{$one->id_review}}">{{$one->name_review}}</td>
                                    <td class="content-{{$one->id_review}}">{{$one->content_review}}</td>
                                    <td class="rating-{{$one->id_review}}">{{$one->rating_review}}</td>
                                    <td>
                                        <button class="btn btn-info reply-review" data-id="{{$one->id_review}}"><i class="fa-solid fa-comments"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->

</div>
@endsection