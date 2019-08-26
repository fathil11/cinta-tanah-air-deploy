@extends('layouts.blog')

@section('judul')
Cinta Tanah Air
@endsection

@section('header')
@endsection

@section('section')
<section class="blog_area single-post-area section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="single-post">
                    <div class="feature-img">
                        <img class="card-img rounded-0"
                            src="{{ url('cinta-tanah-air/public/img/blog') . '/' . $article->banner_path }}" alt="">
                    </div>
                    <div class="blog_details">
                        <h2>{{ $article->title }}</h2>
                        <ul class="blog-info-link mt-3 mb-4">
                            {{-- <li><a href="#"><i class="far fa-user"></i> --}}
                            @php
                            $temp = array();
                            foreach($article->category as $cats){
                            $temp[] = $cats->category;
                            }
                            $cat = implode(',', $temp)
                            @endphp
                            {{ $cat }}</a></li>
                            </a></li>
                            {{-- <li><a href="#"><i class="far fa-comments"></i> 03 Comments</a></li> --}}
                        </ul>
                        {!! $article->article !!}
                    </div>
                </div>
                <div class="navigation-top">
                    <div class="d-sm-flex justify-content-between text-center">

                    </div>
                </div>
                <h3>Penulis</h3>
                <div class="blog-author">
                    <div class="media align-items-center">
                        <img src="{{ url('cinta-tanah-air/public/img/user_picture') . '/' . $article->author->profile_picture }}"
                            alt="">
                        <div class="media-body">
                            <a href="#">
                                <h4>
                                    {{ $article->author->name }}
                                    @if ($article->author->role == 1)
                                    (Admin)
                                    @endif
                                </h4>
                            </a>
                            <p>{{ $article->author->moto }}</p>
                        </div>
                    </div>
                </div>
                <div class="jumbotron">
                    <a class="btn btn-outline-secondary" href="{{ url('admin/draft-artikel') }}">Kembali</a>
                    <a class="btn btn-outline-warning" href="{{ url('admin/edit-artikel') . '/' . $article->id }}">Edit
                        Artikel</a>
                    <a class="btn btn-outline-success"
                        href="{{ url('admin/terbit-artikel') . '/' . $article->id }}">Terbitkan
                        Artikel</a>
                    <a class="btn btn-outline-danger" href="{{ url('admin/tolak-artikel') . '/' . $article->id }}">Tolak
                        Artikel</a>
                </div>
                {{-- <div class="comments-area">
                    <h4>3 Comments</h4>
                    <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                                <div class="thumb">
                                    <img src="{{ asset('img/comment/comment_1.png') }}" alt="">
            </div>
            <div class="desc">
                <p class="comment">
                    Multiply sea night grass fourth day sea lesser rule open subdue female fill
                    which them
                    Blessed, give fill lesser bearing multiply sea night grass fourth day sea lesser
                </p>
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <h5>
                            <a href="#">Emilly Blunt</a>
                        </h5>
                        <p class="date">December 4, 2017 at 3:12 pm </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="comment-list">
        <div class="single-comment justify-content-between d-flex">
            <div class="user justify-content-between d-flex">
                <div class="thumb">
                    <img src="{{ asset('img/comment/comment_2.png') }}" alt="">
                </div>
                <div class="desc">
                    <p class="comment">
                        Multiply sea night grass fourth day sea lesser rule open subdue female fill
                        which them
                        Blessed, give fill lesser bearing multiply sea night grass fourth day sea lesser
                    </p>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5>
                                <a href="#">Emilly Blunt</a>
                            </h5>
                            <p class="date">December 4, 2017 at 3:12 pm </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="comment-list">
        <div class="single-comment justify-content-between d-flex">
            <div class="user justify-content-between d-flex">
                <div class="thumb">
                    <img src="{{ asset('img/comment/comment_3.png') }}" alt="">
                </div>
                <div class="desc">
                    <p class="comment">
                        Multiply sea night grass fourth day sea lesser rule open subdue female fill
                        which them
                        Blessed, give fill lesser bearing multiply sea night grass fourth day sea lesser
                    </p>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5>
                                <a href="#">Emilly Blunt</a>
                            </h5>
                            <p class="date">December 4, 2017 at 3:12 pm </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div> --}}

    </div>
    @endsection
