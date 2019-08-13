@extends('layouts.adminPanel')
@section('title', 'Buat Artikel')
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
            <div>
                @foreach ($errors->all() as $error)
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
            <form action="{{ url('admin/buat-artikel') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="container-fluid">
                    <br>
                    {{-- Input Judul Artikel --}}
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <b>Judul Artikel</b>
                                <input type="text" class="form-control form-control-alternative custom-input-judul"
                                    name="title" placeholder="Judul artikel ...">
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Input Gambar Artikel --}}
                    <div class="row">
                        <div class="col-md-6">
                            <b>Gambar Artikel</b>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input crop-artikel-js" id="customFileLang"
                                    lang="en" name="banner_path">
                                <label class="custom-file-label" for="customFileLang">Pilih gambar ...</label>
                            </div>
                            <input type="hidden" name="x1" value="" />
                            <input type="hidden" name="y1" value="" />
                            <input type="hidden" name="w" value="" />
                            <input type="hidden" name="h" value="" />
                            <br><br>
                            <img width="400" id="previewimage" style="display:none;" />
                        </div>
                    </div>
                    <br><br>

                    {{-- Input Jenis Artikel --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Jenis Artikel</b>
                                <div class="custom-control custom-radio mb-3">
                                    <input name="article_type" class="custom-control-input" id="berita" checked=""
                                        type="radio" value="berita">
                                    <label class="custom-control-label" for="berita">Berita</label>
                                </div>
                                <div class="custom-control custom-radio mb-3">
                                    <input name="article_type" class="custom-control-input" id="bertutur" type="radio"
                                        value="bertutur">
                                    <label class="custom-control-label" for="bertutur">Bertutur</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    {{-- Input Kategori Berita --}}
                    <div id="catber">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <b>Kategori Berita</b>
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input class="custom-control-input" id="budaya" type="checkbox" name="cat[]"
                                            value="budaya">
                                        <label class="custom-control-label" for="budaya">Budaya</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input class="custom-control-input" id="pemberdayaan" type="checkbox"
                                            name="cat[]" value="pemberdayaan">
                                        <label class="custom-control-label" for="pemberdayaan">Pemberdayaan</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input class="custom-control-input" id="pendidikan" type="checkbox" name="cat[]"
                                            value="pendidikan">
                                        <label class="custom-control-label" for="pendidikan">Pendidikan</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input class="custom-control-input" id="sosial" type="checkbox" name="cat[]"
                                            value="sosial">
                                        <label class="custom-control-label" for="sosial">Sosial</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input class="custom-control-input" id="hukum" type="checkbox" name="cat[]"
                                            value="hukum">
                                        <label class="custom-control-label" for="hukum">Hukum</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>

                    {{-- Input WYSIWYG --}}
                    <div class="row">
                        <div class="col-md-12">
                            <b>Tulis Artikel</b>
                            <textarea id="editor" name="editor" placeholder=""></textarea>
                        </div>
                    </div>
                    <br>

                    {{-- Tombol Posting --}}
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Posting</button>
                        </div>
                    </div>
                    <br>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
