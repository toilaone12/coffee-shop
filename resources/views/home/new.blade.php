<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section ftco-animate text-center">
                <h2 class="mb-4">Blog về món ăn</h2>
            </div>
        </div>
        <div class="row d-flex">
            @foreach($news as $key => $new)
            <div class="col-md-4 d-flex ftco-animate">
                <div class="blog-entry align-self-stretch">
                    <a href="{{route('blog.detail',['slug' => $new->slug_new, 'id' => $new->id_new])}}" class="block-20" style="background-image: url('{{asset($new->image_new)}}');">
                    </a>
                    <div class="text py-4 d-block">
                        <div class="meta">
                            <div><a href="{{route('blog.detail',['slug' => $new->slug_new, 'id' => $new->id_new])}}">{{date('d/m/Y',strtotime($new->updated_at))}}</a></div>
                            <span> - </span>
                            <div><a href="{{route('blog.detail',['slug' => $new->slug_new, 'id' => $new->id_new])}}">Quản trị viên</a></div>
                        </div>
                        <h3 class="heading mt-2"><a href="{{route('blog.detail',['slug' => $new->slug_new, 'id' => $new->id_new])}}">{{$new->title_new}}</a></h3>
                        <p>{{$new->subtitle_new}}</p>
                    </div>
                </div>
            </div>
            @if($key == 2)    
                @php
                break;
                @endphp
            @endif
            @endforeach
        </div>
    </div>
</section>