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
    <div class="col-md-12">
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-bell-55"></i></span>
            <span class="alert-inner--text"> {{ Session::get('success') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-bell-55"></i></span>
            <span class="alert-inner--text"> {{ Session::get('error') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
    <div class="col-md-12">
        <div class="card shadow cardcustom">
            <div class="container table-responsive">
                <br>
                <table id="article_table" class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th>
                                Id
                            </th>

                            <th>
                                Judul Artikel
                            </th>

                            <th>
                                Tipe Artikel
                            </th>

                            <th>
                                Kategori
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Status
                            </th>

                            <th>

                            </th>

                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($articles as $article)
                        <tr>
                            <td>
                                {{ $article->id }}
                            </td>

                            <td scope="row">
                                <a target="blank"
                                    href="{{ 'https://www.cintatanahair.id/lihat-artikel/' . $article->slug }}">{{ $article->title }}</a>
                            </td>

                            <td>
                                {{ $article->type }}
                            </td>

                            <td>
                                @php
                                $temp = array();
                                foreach($article->category as $cats){
                                $temp[] = $cats->category;
                                }
                                $cat = implode('<br>', $temp)
                                @endphp
                                {!! $cat !!}
                            </td>

                            <td>
                                {{ date('d F, Y', strtotime($article->created_at)) }}
                            </td>

                            <td>
                                @if ($article->status == 4)
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-danger"></i> ditolak
                                </span>
                                @elseif($article->status == 3)
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-warning"></i> antrian
                                </span>
                                @elseif($article->status == 2)
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-primary"></i> ditinjau
                                </span>
                                @elseif($article->status == 1)
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-success"></i> terbit
                                </span>
                                @endif
                            </td>

                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item"
                                            href="{{ url('author/edit-artikel') . '/' . $article->id }}">Edit</a>
                                        <a class="dropdown-item"
                                            href="{{ url('author/delete-artikel') . '/' . $article->id }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br><br>
            </div>
        </div>
    </div>
</div>
@endsection
