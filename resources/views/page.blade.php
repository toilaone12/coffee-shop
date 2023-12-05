<!DOCTYPE html>
<html lang="en">
@include('home.head')

<body>
    @include('home.navbar')
    <!-- END nav -->

    @yield('content')

    <footer class="ftco-footer ftco-section img">
        <div class="overlay"></div>
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Thông tin liên hệ</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">Khu TT3B, 17, Khu đô thị Phùng Khoang, Nam Từ Liêm, Hà Nội</span></li>
                                <li><span class="icon icon-phone"></span><span class="text">(+84) 985 104 987</span></li>
                                <li><span class="icon icon-envelope"></span><span class="text">harper7coffee@gmail.com</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">

                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        © 2019-2023. Harper 7 Coffee & Bakery. <i class="icon-heart" aria-hidden="true"></i>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>
            </div>
        </div>
    </footer>



    <!-- loader -->
    <!-- <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div> -->


    @include('home.script')

</body>

</html>