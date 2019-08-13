@extends('layouts.dashboard')
@section('title', 'Cinta Tanah Air')
@section('content')
<!-- banner part start-->
<section class="banner_part">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-6 col-md-6">
                <div class="banner_text">
                    <div class="banner_text_iner text-center">
                        <h2>Cinta <span>Tanah Air</span> </h2>
                        <h3>Indonesia</h3>
                        <a href="{{ url('/berita') }}" class="btn_1">Lihat Berita <i class="ti-angle-right"></i> </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="banner_bg">
                    <img src="{{ url('img/banner_img.png') }}" alt="banner">
                </div>
            </div>
        </div>
    </div>
    <div class="hero-app-1 custom-animation"><img src="img/animate_icon/icon_1.png" alt=""></div>
    <div class="hero-app-5 custom-animation2"><img src="img/animate_icon/icon_3.png" alt=""></div>
    <div class="hero-app-7 custom-animation3"><img src="img/animate_icon/icon_2.png" alt=""></div>
    <div class="hero-app-8 custom-animation"><img src="img/animate_icon/icon_4.png" alt=""></div>
</section>
<!-- banner part start-->

<!-- cta part start-->
<section class="cta_part">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="cta_part_iner">
                    <div class="cta_part_text">
                        <p> Slogan Kita</p>
                        <h1>"Merajut Perdamaian Indonesia"</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- cta part end-->



<!-- happy_client counter start -->
<section class="happy_client">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6">
                <div class="single_happy_client">
                    <img src="img/icon/cap.svg" alt="cap">
                    <span class="counter">81</span>
                    <h4>Pengunjung <br>Hari Ini</h4>
                </div>
            </div>

            <div class="col-lg-6 col-sm-6">
                <div class="single_happy_client">
                    <img src="img/icon/cafe.svg" alt="cap">
                    <span class="counter">12</span>
                    <h4>Berita<br>Terbaru</h4>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- happy_client counter end -->



<!--::blog_part start::-->
<section class="blog_part section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5">
                <div class="section_tittle text-center">
                    <h2>Berita Terbaru</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-4 col-xl-4 d-none d-sm-block d-lg-none">
                <div class="single-home-blog">
                    <div class="card">
                        <img src="img/blog/blog_3.png" class="card-img-top" alt="blog">
                        <div class="card-body">
                            <a href="blog.html">Art, design</a> | <span> March 30, 2019</span>
                            <a href="blog.html">
                                <h5 class="card-title">Seasons form upon days may wont bring given herb sixth</h5>
                            </a>
                            <ul>
                                <li> <i class="ti-comments"></i>4 Comments</li>
                                <li> <i class="ti-eye"></i>10 View</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-4">
                <div class="single-home-blog">
                    <div class="card">
                        <img src="img/blog/blog_1.png" class="card-img-top" alt="blog">
                        <div class="card-body">
                            <a href="blog.html">Technology</a> | <span> March 30, 2019</span>
                            <a href="blog.html">
                                <h5 class="card-title">Seasons form upon days may wont bring given herb sixth</h5>
                            </a>
                            <ul>
                                <li> <i class="ti-comments"></i>4 Comments</li>
                                <li> <i class="ti-eye"></i>10 View</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-4">
                <div class="single-home-blog">
                    <div class="card">
                        <img src="img/blog/blog_2.png" class="card-img-top" alt="blog">
                        <div class="card-body">
                            <a href="blog.html">Technology</a> | <span> March 30, 2019</span>
                            <a href="blog.html">
                                <h5 class="card-title">Very and third him beginning signs hath subdue make
                                </h5>
                            </a>
                            <ul>
                                <li> <i class="ti-comments"></i>4 Comments</li>
                                <li> <i class="ti-eye"></i>10 View</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-4">
                <div class="single-home-blog">
                    <div class="card">
                        <img src="img/blog/blog_3.png" class="card-img-top" alt="blog">
                        <div class="card-body">
                            <a href="blog.html">Technology</a> | <span> March 30, 2019</span>
                            <a href="blog.html">
                                <h5 class="card-title">Seasons form upon days may wont bring given herb sixth</h5>
                            </a>
                            <ul>
                                <li> <i class="ti-comments"></i>4 Comments</li>
                                <li> <i class="ti-eye"></i>10 View</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--::blog_part end::-->
@endsection
