<div class="modal fade" id="forgotPassword" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog d-flex justify-content-center">
        <div class="modal-content form-login">
            <div class="section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center align-self-center py-2">
                            <div class="section pb-5 pt-5 pt-sm-2 text-center">
                                <div class="card-3d-wrap mx-auto" style="height: 300px;">
                                    <div class="card-3d-wrapper">
                                        <div class="card-front">
                                            <div class="center-wrap">
                                                <div class="section text-center">
                                                    <h4 class="mb-4 pb-3 fs-24">Quên mật khẩu</h4>
                                                    <form class="forgot-password-customer">
                                                        <div class="form-group position-relative">
                                                            <input type="email" name="email_forgot" class="form-style" placeholder="Email" id="logemail" autocomplete="off" value="{{$email ? $email : old('email')}}">
                                                            <span class="icon-at input-icon"></span>
                                                        </div>
                                                        <span class="text-danger error-forgot-email d-block fs-12"></span>
                                                        <button type="submit" class="btn btn-primary btn-outline-primary mt-4 px-4 fs-16">Xác nhận</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>