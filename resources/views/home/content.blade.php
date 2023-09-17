@extends('page')
@section('content')

@include('home.slide')

<section class="ftco-section ftco-services">
    <div class="container">
        <div class="row">
            <div class="col-md-4 ftco-animate">
                <div class="media d-block text-center block-6 services">
                    <div class="icon d-flex justify-content-center align-items-center mb-5">
                        <span class="flaticon-choices"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Đặt hàng đơn giản</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ftco-animate">
                <div class="media d-block text-center block-6 services">
                    <div class="icon d-flex justify-content-center align-items-center mb-5">
                        <span class="flaticon-delivery-truck"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Vận chuyển nhanh chóng</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ftco-animate">
                <div class="media d-block text-center block-6 services">
                    <div class="icon d-flex justify-content-center align-items-center mb-5">
                        <span class="flaticon-coffee-bean"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Chất lượng sản phẩm cao</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 pr-md-5">
                <div class="heading-section text-md-right ftco-animate">
                    <h2 class="mb-4">Thực đơn của chúng tôi</h2>
                    <p><a href="#" class="btn btn-primary btn-outline-primary px-4 py-3">Harper 7'S Menu</a></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="menu-entry">
                            <a href="#" class="img" style="background-image: url({{asset('front-end/image/menu-1.jpg')}});"></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="menu-entry mt-lg-4">
                            <a href="#" class="img" style="background-image: url({{asset('front-end/image/menu-2.jpg')}});"></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="menu-entry">
                            <a href="#" class="img" style="background-image: url({{asset('front-end/image/menu-3.jpg')}});"></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="menu-entry mt-lg-4">
                            <a href="#" class="img" style="background-image: url({{asset('front-end/image/menu-4.jpg')}});"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('home.menu')

<section class="ftco-section img" id="ftco-testimony" style="background-image: url({{asset('front-end/image/bg_1.jpg')}});" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <span class="subheading">Testimony</span>
                <h2 class="mb-4">Customers Says</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
        </div>
    </div>
    <div class="container-wrap">
        <div class="row d-flex no-gutters">
            <div class="col-lg align-self-sm-end">
                <div class="testimony overlay">
                    <blockquote>
                        <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.&rdquo;</p>
                    </blockquote>
                    <div class="author d-flex mt-4">
                        <div class="image mr-3 align-self-center">
                            <img loading="lazy" src="{{asset('front-end/image/person_2.jpg')}}" alt="">
                        </div>
                        <div class="name align-self-center">Louise Kelly <span class="position">Illustrator Designer</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg align-self-sm-end ftco-animate">
                <div class="testimony">
                    <blockquote>
                        <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name. &rdquo;</p>
                    </blockquote>
                    <div class="author d-flex mt-4">
                        <div class="image mr-3 align-self-center">
                            <img loading="lazy" src="{{asset('front-end/image/person_3.jpg')}}" alt="">
                        </div>
                        <div class="name align-self-center">Louise Kelly <span class="position">Illustrator Designer</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg align-self-sm-end">
                <div class="testimony overlay">
                    <blockquote>
                        <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however.&rdquo;</p>
                    </blockquote>
                    <div class="author d-flex mt-4">
                        <div class="image mr-3 align-self-center">
                            <img loading="lazy" src="{{asset('front-end/image/person_2.jpg')}}" alt="">
                        </div>
                        <div class="name align-self-center">Louise Kelly <span class="position">Illustrator Designer</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg align-self-sm-end ftco-animate">
                <div class="testimony">
                    <blockquote>
                        <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name. &rdquo;</p>
                    </blockquote>
                    <div class="author d-flex mt-4">
                        <div class="image mr-3 align-self-center">
                            <img loading="lazy" src="{{asset('front-end/image/person_3.jpg')}}" alt="">
                        </div>
                        <div class="name align-self-center">Louise Kelly <span class="position">Illustrator Designer</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('home.new')


<section class="ftco-appointment">
    <div class="overlay"></div>
    <div class="container-wrap">
        <div class="row no-gutters d-md-flex align-items-center">
            <div class="col-md-6 d-flex align-self-stretch">
                <!-- <div id="map"></div> -->
            </div>
            <div class="col-md-6 appointment ftco-animate">
                <h3 class="mb-3">Book a Table</h3>
                <form action="#" class="appointment-form">
                    <div class="d-md-flex">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="First Name">
                        </div>
                        <div class="form-group ml-md-4">
                            <input type="text" class="form-control" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group">
                            <div class="input-wrap">
                                <div class="icon"><span class="ion-md-calendar"></span></div>
                                <input type="text" class="form-control appointment_date" placeholder="Date">
                            </div>
                        </div>
                        <div class="form-group ml-md-4">
                            <div class="input-wrap">
                                <div class="icon"><span class="ion-ios-clock"></span></div>
                                <input type="text" class="form-control appointment_time" placeholder="Time">
                            </div>
                        </div>
                        <div class="form-group ml-md-4">
                            <input type="text" class="form-control" placeholder="Phone">
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group">
                            <textarea name="" id="" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
                        </div>
                        <div class="form-group ml-md-4">
                            <input type="submit" value="Appointment" class="btn btn-primary py-3 px-4">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection