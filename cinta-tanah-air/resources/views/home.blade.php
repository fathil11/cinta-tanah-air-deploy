<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Cinta Tanah Air</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/favicon.png') }}">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/index-css.css') }}">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/custom-index.css') }}">

</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header-area">

        <!-- Top Header Area -->
        <div class="top-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="top-header-content d-flex align-items-center justify-content-between">
                            <!-- Logo -->
                            <div class="logo">
                                <a href="index.html"><img src="{{ asset('img/home/logo.png') }}" alt=""></a>
                            </div>

                            <!-- Login Search Area -->
                            <div class="login-search-area d-flex align-items-center">
                                <!-- Search Form -->
                                <div class="search-form">
                                    <form action="#" method="post">
                                        <input type="search" name="search" class="form-control" placeholder="Search">
                                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navbar Area -->
        <div class="newspaper-main-menu" id="stickyMenu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="newspaperNav">

                        <!-- Logo -->
                        <div class="logo">
                            <a href="index.html"><img src="{{ asset('img/home/logo.png') }}" alt=""></a>
                        </div>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- close btn -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li class="active"><a href="{{ url('/') }}">Beranda</a></li>
                                    <li><a href="#">Berita</a>
                                        <ul class="dropdown">
                                            <li><a href="{{ url('/berita') }}">Semua Berita</a></li>
                                            <li><a href="{{ url('/berita/budaya') }}">Budaya</a></li>
                                            <li><a href="{{ url('/berita/pemberdayaan') }}">Pemberdayaan</a></li>
                                            <li><a href="{{ url('/berita/pendidikan') }}">Pendidikan</a></li>
                                            <li><a href="{{ url('/berita/sosial') }}">Sosial</a></li>
                                            <li><a href="{{ url('/berita/hukum') }}">Hukum</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ url('/bertutur') }}">Bertutur</a></li>
                                    <li><a href="{{ url('/profil') }}">Profil</a></li>
                                </ul>
                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Hero Area Start ##### -->
    <div class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-12">
                    <!-- Breaking News Widget -->
                    <div class="breaking-news-area d-flex align-items-center">
                        <div class="news-title">
                            <p>Berita Terbaru</p>
                        </div>
                        <div id="breakingNewsTicker" class="ticker">
                            <ul>
                                @if ($stat['top_3_articles']->isEmpty())
                                <h3>Maaf, belum ada berita hari ini.</h3>
                                @else
                                @foreach ($stat['top_3_articles'] as $article)
                                <li><a
                                        href="{{ url('lihat-artikel') . '/' . $article->slug }}">{{ $article->title }}</a>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Featured Post Area Start ##### -->
    <div class="featured-post-area">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="row">

                        <!-- Single Featured Post -->
                        <div class="col-12 col-lg-7">
                            <div class="single-blog-post featured-post">
                                <div class="post-thumb">
                                    <a href="{{ url('lihat-artikel') . '/' . $articles[0]->slug }}"><img
                                            src="{{ url('cinta-tanah-air/public/img/blog') . '/' . $articles[0]->banner_path }}"
                                            alt=""></a>
                                </div>
                                <div class="post-data">
                                    <a href="{{ url('lihat-artikel') . '/' . $articles[0]->slug }}"
                                        class="post-catagory">
                                        @php
                                        $temp = array();
                                        foreach($articles[0]->category as $cats){
                                        $temp[] = $cats->category;
                                        }
                                        $cat = implode(',', $temp)
                                        @endphp
                                        {{ $cat }}</a>
                                    <a href="{{ url('lihat-artikel') . '/' . $articles[0]->slug }}" class="post-title">
                                        <h6>{{ $articles[0]->title }}</h6>
                                    </a>
                                    <div class="post-meta">
                                        <p class="post-author">By <a href="#">{{ $articles[0]->author->name }}
                                                @if ($articles[0]->author->role == 1)
                                                (Admin)
                                                @endif</a></p>
                                        <p class="post-excerp">@php
                                            $tny_art = new HtmlToText($articles[0]->article);
                                            $tny_art = $tny_art->getText();
                                            @endphp
                                            {{ substr($tny_art, 0, 250) . "..." }}</p>
                                        <!-- Post Like & Post Comment -->
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="post-like"><img src="{{ asset('img/icon/view.png') }}"
                                                    alt="">
                                                <span>{{ count($articles[0]->statistic) }} View</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <!-- Single Featured Post -->
                            <div class="single-blog-post featured-post-2">
                                <div class="post-thumb">
                                    <a href="{{ url('lihat-artikel') . '/' . $articles[1]->slug }}"><img
                                            src="{{ url('cinta-tanah-air/public/img/blog') . '/' . $articles[1]->banner_path }}"
                                            alt=""></a>
                                </div>
                                <div class="post-data">
                                    <a href="{{ url('lihat-artikel') . '/' . $articles[1]->slug }}"
                                        class="post-catagory">
                                        @php
                                        $temp = array();
                                        foreach($articles[1]->category as $cats){
                                        $temp[] = $cats->category;
                                        }
                                        $cat = implode(',', $temp)
                                        @endphp
                                        {{ $cat }}
                                    </a>
                                    <div class="post-meta">
                                        <a href="{{ url('lihat-artikel') . '/' . $articles[1]->slug }}"
                                            class="post-title">
                                            <h6>{{ $articles[1]->title }}</h6>
                                            <p class="post-excerp" style="margin-bottom: 0.1rem;">@php
                                                $tny_art = new HtmlToText($articles[1]->article);
                                                $tny_art = $tny_art->getText();
                                                @endphp
                                                {{ substr($tny_art, 0, 50) . "..." }}</p>
                                        </a>
                                        <!-- Post Like & Post Comment -->
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="post-like"><img src="{{ asset('img/icon/view.png') }}"
                                                    alt="">
                                                <span>{{ count($articles[1]->statistic) }} View</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="single-blog-post featured-post-2">
                                <div class="post-thumb">
                                    <a href="{{ url('lihat-artikel') . '/' . $articles[2]->slug }}"><img
                                            src="{{ url('cinta-tanah-air/public/img/blog') . '/' . $articles[2]->banner_path }}"
                                            alt=""></a>
                                </div>
                                <div class="post-data">
                                    <a href="{{ url('lihat-artikel') . '/' . $articles[2]->slug }}"
                                        class="post-catagory">
                                        @php
                                        $temp = array();
                                        foreach($articles[2]->category as $cats){
                                        $temp[] = $cats->category;
                                        }
                                        $cat = implode(',', $temp)
                                        @endphp
                                        {{ $cat }}
                                    </a>
                                    <div class="post-meta">
                                        <a href="{{ url('lihat-artikel') . '/' . $articles[2]->slug }}"
                                            class="post-title">
                                            <h6>{{ $articles[2]->title }}</h6>
                                            <p class="post-excerp" style="margin-bottom: 0.1rem;">
                                                @php
                                                $tny_art = new HtmlToText($articles[2]->article);
                                                $tny_art = $tny_art->getText();
                                                @endphp
                                                {{ substr($tny_art, 0, 50) . "..." }}</p>
                                        </a>
                                        <!-- Post Like & Post Comment -->
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="post-like"><img src="{{ asset('img/icon/view.png') }}"
                                                    alt="">
                                                <span>{{ count($articles[2]->statistic) }} View</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <!-- Single Featured Post -->
                    @foreach ($articles as $key => $article)
                    @if ($key > 2 && $key < 8) <div class="single-blog-post small-featured-post d-flex">
                        <div class="post-thumb">
                            <a href="{{ url('lihat-artikel') . '/' . $article->slug }}"><img
                                    src="{{ url('cinta-tanah-air/public/img/blog') . '/' . $article->banner_path }}"
                                    alt="gambar_artikel"></a>
                        </div>
                        <div class="post-data">
                            <a href="{{ url('lihat-artikel') . '/' . $article->slug }}" class="post-catagory">
                                @php
                                $temp = array();
                                foreach($article->category as $cats){
                                $temp[] = $cats->category;
                                }
                                $cat = implode(',', $temp)
                                @endphp
                                {{ $cat }}
                            </a>
                            <div class="post-meta">
                                <a href="{{ url('lihat-artikel') . '/' . $article->slug }}" class="post-title">
                                    <h6>{{ $article->title }}</h6>
                                </a>
                                <p class="post-date"><span>{{ date('h:i A', strtotime($article->created_at)) }}</span> |
                                    <span>{{ date('F d', strtotime($article->created_at)) }}</span></p>
                            </div>
                        </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    </div>
    <!-- ##### Featured Post Area End ##### -->





    <!-- ##### Editorial Post Area Start ##### -->
    <div class="editors-pick-post-area section-padding-80-50">
        <div class="container">
            <div class="row">
                <!-- Editors Pick -->
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="section-heading">
                        <h6>Berita Terpopuler</h6>
                    </div>

                    <div class="row">
                    @foreach ($popular_articles as $key=>$article)
                    @if ($key < 6)
                    <div class="col-12 col-lg-4">
                        <div class="single-blog-post">
                            <div class="post-thumb">
                                <a href="{{ url('lihat-artikel') . '/' . $article->slug }}"><img src="{{ url('cinta-tanah-air/public/img/blog') . '/' . $article->banner_path }}" alt=""></a>
                            </div>
                            <div class="post-data">
                                <a href="{{ url('lihat-artikel') . '/' . $article->slug }}" class="post-title">
                                    <h6>{{ $article->title }}</h6>
                                    <p>
                                        @php
                                        $tny_art = new HtmlToText($article->article);
                                        $tny_art = $tny_art->getText();
                                        @endphp
                                        {{ substr($tny_art, 0, 100) . "..." }}</p>
                                    </p>
                                </a>
                                <div class="post-meta">
                                    <div class="post-date"><a href="{{ url('lihat-artikel') . '/' . $article->slug }}">February 11, 2018</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach

                </div>
            </div>


        </div>
    </div>
    </div>
    <!-- ##### Editorial Post Area End ##### -->


    <!-- ##### Footer Add Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area">

        <!-- Main Footer Area -->
        <div class="main-footer-area">
            <div class="container">
                <div class="row">

                    <!-- Footer Widget Area -->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="footer-widget-area mt-80">
                            <!-- Footer Logo -->
                            <div class="footer-logo">
                                <a href="{{ url('/') }}"><img src="{{ asset('img/home/logo.png') }}" alt=""></a>
                            </div>

                            <!-- List -->
                            <ul class="list">
                                <li><a href="mailto:contact@youremail.com">E-mail : info@cintatanahair.id</a></li>
                                <li><a href="tel:+4352782883884">Telp : 0812-2870-3110</a></li>
                                <li><a href="https://cintatanahair.id">Site : cintatanahair.id</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer Area -->
        <div class="bottom-footer-area">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <!-- Copywrite -->
                        <p>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | by <a href="https://colorlib.com" target="_blank">CTA
                                Team</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area Start ##### -->

    <!-- ##### All Javascript Files ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="{{ asset('js/jquery-1.12.1.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- All Plugins js -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <!-- Active js -->
    <script src="{{ asset('js/active.js') }}"></script>
</body>

</html>
