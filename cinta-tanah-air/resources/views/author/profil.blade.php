@extends('layouts.authorPanel')
@section('title', 'Author Panel')
@section('header')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow cardcustom">
            <form action="{{ url('testing') }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="container-fluid">
                    <br>
                    {{-- Input Nama User --}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <b>Nama</b>
                                <input type="text" class="form-control form-control-alternative" name="nama"
                                    placeholder="Nama user ..." required>
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Input Email User --}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <b>E-mail</b>
                                <input type="email" class="form-control form-control-alternative" name="email"
                                    placeholder="Email user ..." required>
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Input Password User --}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <b>Password</b>
                                <input type="password" class="form-control form-control-alternative" name="email"
                                    placeholder="Password user ..." required>
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Input Ulangi Password User --}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <b>Ulangi Password</b>
                                <input type="password" class="form-control form-control-alternative" name="email"
                                    placeholder="Ulangi password user ..." required>
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Input Level User --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Jenis User</b>
                                <div class="custom-control custom-radio mb-3">
                                    <input name="jenis_user" class="custom-control-input" id="admin" type="radio">
                                    <label class="custom-control-label" for="admin">Admin</label>
                                </div>
                                <div class="custom-control custom-radio mb-3">
                                    <input name="jenis_user" class="custom-control-input" id="penulis" type="radio">
                                    <label class="custom-control-label" for="penulis">Penulis</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Tombol Posting --}}
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Register User</button>
                        </div>
                    </div>
                    <br>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
