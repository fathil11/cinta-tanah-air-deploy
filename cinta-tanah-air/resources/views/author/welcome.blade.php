@extends('layouts.authorPanel')
@section('title', 'Author Panel')
@section('header')
<div class="header bg-gradient-primary pb-8 pt-5 pt-lg-8 d-flex align-items-center">
    <!-- Header container -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10 text-center">
                <h1 class="display-2 text-white">Aku Cinta Indonesia <br><small>Author Panel</small></h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="card bg-gradient-defaultcustom text-center p-5">
            <a href="{{ url('author/buat-artikel') }}" class="btn btn-white btn-icon mb-3 mb-sm-0">
                <span class="btn-inner--icon"><i class="ni ni-collection"></i></span>
                <span class="btn-inner--text">Buat Artikel</span>
            </a>
        </div>
    </div>
</div>
@endsection
