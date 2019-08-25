@extends('layouts.adminPanel')
@section('title', 'Draft Artikel')
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
                <div>
                    <table id="draft_article_table" class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">
                                    Id
                                </th>
                                <th scope="col">
                                    Judul Artikel
                                </th>
                                <th scope="col">
                                    Penulis
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
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($articles as $article)
                            <tr>
                                <td scope="row">
                                    {{ $article->id }}
                                </td>

                                <td>
                                    {{ $article->title }}
                                </td>

                                <td class="status">
                                    {{ $article->author->name }}
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
                                    @if($article->status == 2)
                                    <span class="badge badge-dot mr-4">
                                        <i class="bg-primary"></i> ditinjau
                                    </span>
                                    @elseif($article->status == 3)
                                    <span class="badge badge-dot mr-4">
                                        <i class="bg-warning"></i> antrian
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
                                                onclick="reloadAndOpenNewTab({{ url('admin/tinjau-artikel') . '/' . $article->id }})"
                                                href="#">Tinjau</a>
                                            <a class="dropdown-item"
                                                href="{{ url('admin/edit-artikel') . '/' . $article->id }}">Edit</a>
                                            <a class="dropdown-item"
                                                href="{{ url('admin/terbit-artikel') . '/' . $article->id }}">Terbitkan</a>
                                            <a class="dropdown-item"
                                                href="{{ url('admin/tolak-artikel') . '/' . $article->id }}">Tolak</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br><br>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function reloadAndOpenNewTab(url){
        //Open in new tab
        console.log(url);
        window.open(url, '_blank');
        //focus to thet window
        window.focus();
        //reload current page
        location.reload();
    }
</script>
