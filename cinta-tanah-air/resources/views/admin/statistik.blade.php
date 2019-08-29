@extends('layouts.adminPanel')
@section('title', 'Statistik')
@section('header')

<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Pengunjung Hari Ini</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $stat['view_per_day_count'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fa fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                {{-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>91%</span> --}}
                                <span class="text-nowrap">{{ $stat['view_per_day_count'] }} Pengunjung Hari Ini</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Semua Artikel</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $stat['article_count'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                        <i class="fa fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                {{-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span> --}}
                                <span class="text-nowrap">{{ $stat['article_per_day_count'] }} Artikel Terposting Hari
                                    Ini</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Artikel Tertunda</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $stat['article_postponed_count'] }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                {{-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span> --}}
                                <span class="text-nowrap">{{ $stat['article_postponed_per_day_count'] }} Tertunda Hari
                                    Ini</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Komentar</h5>
                                    <span class="h2 font-weight-bold mb-0">-</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-align-center"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                {{-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span> --}}
                                <span class="text-nowrap">-</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12 mb-12 mb-xl-0">
        <div class="card bg-gradient-default shadow">
            <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="text-white mb-0">Postingan Artikel Minggu Ini</h2>
                    </div>
                    <div class="col">
                        <ul class="nav nav-pills justify-content-end">

                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Chart -->
                <div class="chart">
                    <!-- Chart wrapper -->
                    <canvas id="articles-chart" class="chart-canvas"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row mt-5">
    <div class="col-xl-12 mb-12 mb-xl-0">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Statistik Artikel</h3>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Judul Artikel</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Dilihat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                        <tr>
                            <th scope="row">
                                <a target="blank"
                                    href="{{ url('lihat-artikel') . '/' . $article->slug }}">{{ $article->title }}</a>
                            </th>
                            <td>
                                {{ $article->author->name }}
                            </td>
                            <td>
                                {{ date('d F, Y', strtotime($article->created_at)) }}
                            </td>
                            <td>
                                {{ count($article->statistic) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
