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
        @include('layouts.validationMessage')
    </div>
    <div class="col-md-12">
        <div class="card shadow cardcustom">
            <div class="container table-responsive">
                <br>
                <table id="article_table" class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">
                                Id
                            </th>

                            <th scope="col">
                                Judul Artikel
                            </th>

                            <th scope="col">
                                Tipe Artikel
                            </th>

                            <th scope="col">
                                Kategori
                            </th>

                            <th scope="col">
                                Tanggal
                            </th>

                            <th scope="col">
                                Status
                            </th>

                            <th scope="col">

                            </th>

                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($articles as $article)
                        <tr>
                            <th scope="row">
                                {{ $article->id }}
                            </th>

                            <th scope="row">
                                <a target="blank"
                                    href="{{ url('author/lihat-artikel') . '/' . $article->id }}">{{ $article->title }}</a>
                            </th>

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
