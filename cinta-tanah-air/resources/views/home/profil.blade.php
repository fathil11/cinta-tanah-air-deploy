@extends('layouts.blog')

@section('judul')
Profil Kami
@endsection

@section('header')
<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner text-center">
                    <div class="breadcrumb_iner_item">
                        <h2>Profil Kami</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('section')
<section class="blog_area single-post-area section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="jumbotron">
                    <div class="col-lg-4">
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-home"></i></span>
                            <div class="media-body">
                                <h3>Semarang Tengah, Semarang.</h3>
                                <p>Jl. Pemuda No.15</p>
                            </div>
                        </div>
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                            <div class="media-body">
                                <h3>(024) 547 098</h3>
                                <p>10 Pagi - 5 Sore</p>
                            </div>
                        </div>
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-email"></i></span>
                            <div class="media-body">
                                <h3>cintatanahair@gmail.com</h3>
                                <p>Beri kami masukan .</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection
