@extends('layouts.adminPanel')
@section('title', 'Edit User')
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
    @if ($errors->any())
    <div class="col-md-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div @foreach ($errors->all() as $error)
                <li>
                    <span class="alert-inner--text">{{ $error }}</span>
                </li>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    @endif
    <div class="col">
        <div class="card shadow cardcustom">
            <form action="{{ url('admin/edit-user') . '/' . $user->id }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="container-fluid">
                    <br>
                    <div class="col-md-12">

                    </div>
                    {{-- Input Nama User --}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <b>Nama</b>
                                <input type="text" class="form-control form-control-alternative" name="name"
                                    placeholder="Nama user ..." value="{{ $user->name }}" required>
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
                                    placeholder="Email user ..." value="{{ $user->email }}" required>
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Input Moto User --}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <b>Moto</b>
                                <input type="text" class="form-control form-control-alternative" name="moto"
                                    value="{{ $user->moto }}" placeholder="Moto user ...">
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Input Password User --}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <b>Reset Password</b>
                                <input type="password" class="form-control form-control-alternative" name="password"
                                    placeholder="Kosongkan jika tidak ingin merubah ...">
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Input Ulangi Password User --}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <b>Ulangi Password</b>
                                <input type="password" class="form-control form-control-alternative"
                                    name="password_confirmation" placeholder="Kosongkan jika tidak ingin merubah ...">
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
                                    <input name="role" class="custom-control-input" id="admin" type="radio"
                                        value="admin" @if ($user->role == 1)
                                    checked
                                    @endif>
                                    <label class="custom-control-label" for="admin">Admin</label>
                                </div>
                                <div class="custom-control custom-radio mb-3">
                                    <input name="role" class="custom-control-input" id="penulis" type="radio"
                                        value="author" @if ($user->role == 2)
                                    checked
                                    @endif>
                                    <label class="custom-control-label" for="penulis">Penulis</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Tombol Posting --}}
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </div>
                    <br>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
