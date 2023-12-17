<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-25 text-secondary" id="exampleModalLabel">Sửa thông tin cá nhân</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="update-info" enctype="multipart/form-data" data-id="{{request()->cookie('id_customer')}}">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="fs-15">Ảnh đại diện gốc</label>
                                    <img class="image-update img-thumbnail d-block" width="200" height="100" src="{{asset($customer->image_customer)}}" class="mt-5">
                                    <input type="hidden" name="image_original" class="image-original" value="{{$customer->image_customer}}">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <label class="fs-15">Ảnh đại diện mới</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input border change-image-profile" name="image" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="fs-15 custom-file-label" for="inputGroupFile01">Chọn ảnh</label>
                                </div>
                                <div class="fs-16 mt-2 name-image"></div>
                                <span class="text-danger fs-12 error-image"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="fs-15" for="fullname">Họ & tên</label>
                                <input type="text" name="fullname" id="fullname" value="{{$customer->name_customer}}" style="outline:none" class="border w-100 text-secondary fs-14 px-2 py-1 rounded fullname-update">
                                <span class="text-danger error-fullname fs-12"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="fs-15" for="email">Email</label>
                                <input type="text" name="email" id="email" value="{{$customer->email_customer}}" style="outline:none" class="border w-100 text-secondary fs-14 px-2 py-1 rounded email-update">
                                <span class="text-danger error-email fs-12"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="fs-15" for="phone">Số điện thoại</label>
                                <input type="text" name="phone" id="phone" value="{{$customer->phone_customer}}" style="outline:none" class="border w-100 text-secondary fs-14 px-2 py-1 rounded phone-update">
                                <span class="text-danger error-phone fs-12"></span>
                            </div>
                        </div>
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