@extends('layouts.adminPanel')
@section('title', 'Kelola Artikel')
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
            <span class="alert-inner--text"> {{ Session::get('status') }}</span>
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
            <div class="container">
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
                                Penulis
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($articles as $article)
                        <tr>
                            <td scope="row">
                                {{ $article->id }}
                            </td>

                            <td>
                                <a target="blank"
                                    href="{{ 'https://www.cintatanahair.id/lihat-artikel/' . $article->slug }}">{{ $article->title }}</a>
                            </td>

                            <td>
                                {{ $article->type }}
                            </td>

                            <td class="completion">
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

                            <td class="status">
                                @if ($article->status == 2)
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-warning"></i> ditunda
                                </span>
                                @elseif($article->status == 1)
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-success"></i> terbit
                                </span>
                                @endif
                            </td>

                            <td class="text-right">
                                {{ $article->author->name }}
                                @if ($article->author->role == 1)
                                (Admin)
                                @else
                                (Penulis)
                                @endif
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
