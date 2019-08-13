@extends('layouts.dashboard')

@section('title')
@yield('judul')
@endsection

@section('content')

@yield('header')

@yield('section')

<div class="col-lg-4">
    <div class="blog_right_sidebar">
        <aside class="single_sidebar_widget search_widget">
            <form action="#">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari berita ...">
                        <div class="input-group-append">
                            <button class="btn" type="button"><i class="ti-search"></i></button>
                        </div>
                    </div>
                </div>
                <button class="button rounded-0 primary-bg text-white w-100 btn_4" type="submit">Cari Berita</button>
            </form>
        </aside>

        <aside class="single_sidebar_widget post_category_widget">
            <h4 class="widget_title">Kategori Berita</h4>
            <ul class="list cat-list">
                <li>
                    <a href="{{ url('berita/budaya') }}" class="d-flex">
                        <p>Budaya</p>
                        <p>({{ $cat_stat['budaya'] }})</p>
                    </a>
                </li>
                <li>
                    <a href="{{ url('berita/pemberdayaan') }}" class="d-flex">
                        <p>Pemberdayaan</p>
                        <p>({{ $cat_stat['pemberdayaan'] }})</p>
                    </a>
                </li>
                <li>
                    <a href="{{ url('berita/pendidikan') }}" class="d-flex">
                        <p>Pendidikan</p>
                        <p>({{ $cat_stat['pendidikan'] }})</p>
                    </a>
                </li>
                <li>
                    <a href="{{ url('berita/sosial') }}" class="d-flex">
                        <p>Sosial</p>
                        <p>({{ $cat_stat['sosial'] }})</p>
                    </a>
                </li>
                <li>
                    <a href="{{ url('berita/hukum') }}" class="d-flex">
                        <p>Hukum</p>
                        <p>({{ $cat_stat['hukum'] }})</p>
                    </a>
                </li>
            </ul>
        </aside>

        <aside class="single_sidebar_widget popular_post_widget">
            <h3 class="widget_title">Berita Terbaru</h3>
            <div class="row">
                @foreach ($art_stat as $art)
                <div class="media post_item">
                    <div class="col-md-5">
                        <img class="img-fluid"
                            src="{{ url('cinta-tanah-air/public/img/blog') . '/' . $art->banner_path }}" alt="post">
                    </div>
                    <div class="media-body">
                        <a href="{{ url('lihat-artikel') . $art->slug }}">
                            <h3>{{ $art->title }}</h3>
                        </a>
                        <p>{{ date('d F Y', strtotime($art->created_at)) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </aside>

        <aside class="single_sidebar_widget newsletter_widget">
            <h4 class="widget_title">Ikuti Setiap Berita Terbaru Kami</h4>

            <form action="#">
                <div class="form-group">
                    <input type="email" class="form-control" onfocus="this.placeholder = ''"
                        onblur="this.placeholder = 'Enter email'" placeholder='Masukan email' required>
                </div>
                <button class="button rounded-0 primary-bg text-white w-100 btn_4" type="submit">Berlangganan</button>
            </form>
        </aside>
    </div>
</div>
</div>
</div>
</section>
<!--================Article Area =================-->
@endsection
