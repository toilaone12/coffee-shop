@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-9 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách phiếu nhập hàng</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Mã phiếu</th>
                                    <th>Tên phiếu</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Tổng sản phẩm</th>
                                    <th>Tình trạng phiếu</th>
                                    <th>Thời gian lập</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                <tr>
                                    <td><input type="checkbox" name="" value="{{$one->id_note}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    <td class="code-{{$one->id_note}}">{{$one->code_note}}</td>
                                    <td class="name-{{$one->id_note}}">{{$one->name_note}}</td>
                                    @foreach($listSupplier as $key => $supplier)
                                    @if($supplier->id_supplier == $one->id_supplier)
                                    <td class="id-supplier-{{$one->id_note}}">{{$supplier->name_supplier}}</td>
                                    @endif
                                    @endforeach
                                    <td class="quantity-{{$one->id_note}}">{{$one->quantity_note}}</td>
                                    <td class="status-{{$one->id_note}}">{{$one->status_note}}</td>
                                    <td class="">{{date(strtotime($one->status_note,'d/M/y H:i'))}}</td>
                                    <td>
                                        <button class="btn btn-primary update-note-{{$one->id_note}} note" data-id="{{$one->id_note}}" data-toggle="modal" data-target="#updateModal"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="btn btn-danger delete-note" data-id="{{$one->id_note}}"><i class="fa-solid fa-trash-can"></i></button>
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
                        <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Nhập phiếu</button>
                        <!-- <button class="btn btn-primary d-block mb-3 w-100" data-toggle="modal" data-target="#exampleModal">Xuất phiếu</button> -->
                        <button disabled class="w-100 disabled btn btn-primary delete-all delete-all-unit d-block mb-3">Xóa nhiều</button>
                        <button class="w-100 btn btn-primary choose-all d-block">Chọn nhiều</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Insert Note -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nhập phiếu hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="insert-note">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Tên phiếu hàng</label>
                                    <input type="text" name="name_note" id="name" class="form-control name-insert">
                                    <span class="text-danger error-insert-name"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="option">Danh sách nhà cung cấp</label>
                                    <select name="id_supplier" id="" class="form-control">
                                        @foreach($listSupplier as $key => $supplier)
                                        <option value="{{$supplier->id_supplier}}" class="form-control id-supplier-insert">{{$supplier->name_supplier}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Tổng số nguyên liệu cần nhập</label>
                            <input type="number" min=1 name="quantity_note" id="quantity" class="form-control quantity-insert">
                            <span class="text-danger error-insert-quantity"></span>
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
    
    <!-- Modal Detail Note -->
    <div class="modal fade" id="anotherModal" tabindex="-1" role="dialog" aria-labelledby="anotherModalLabel" aria-hidden="true">
    <!-- Nội dung của modal khác -->
        <div class="modal-dialog overflow-auto" role="document" style="max-height: 900px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nhập chi tiết phiếu hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post">
                    <div class="modal-body list-detail-note" data-count="" data-code="" data-id="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Update -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa đơn vị tính</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span class="text-success message-unit mx-3"></span>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="fullname">Tên đơn vị</label>
                                <input type="text" name="" id="fullname" class="form-control fullname-update">
                                <span class="text-danger error-fullname"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="abbreviation">Ký hiệu</label>
                                <input type="text" name="" id="abbreviation" class="form-control abbreviation-update">
                                <span class="text-danger error-abbreviation"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary update-unit">Sửa</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Insert -->

    <!-- End of Main Content -->

</div>
@endsection