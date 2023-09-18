<section class="home-slider owl-carousel">
    @foreach($slides as $key => $slide)
    <div class="slider-item" style="background-image: url('{{asset($slide->image_slide)}}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
                <div class="col-md-8 col-sm-12 text-center ftco-animate">
                    <span class="subheading">Chào mừng đến với Harper 7</span>
                    <h1 class="mb-4">Hãy trải nghiệm dịch vụ coffee của chúng tôi với chất lượng tốt nhất</h1>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</section>