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
                                Tanggal
                            </th>
                            <th scope="col">
                                Kategori
                            </th>
                            <th scope="col">
                                Status
                            </th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        <tr>
                            <td scope="row">
                                1
                            </td>
                            <td>
                                Promosi Asian Games, Bali Gelar Kampung Olahraga
                            </td>

                            <td>
                                21 September 2019
                            </td>
                            <td class="completion">
                                Politik, Budaya, Sosial
                            </td>
                            <td class="status">
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-warning"></i> ditarik
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" href="#">Hapus</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td scope="row">
                                2
                            </td>
                            <td>
                                Indonesia media mogul earmarks $500m for M&A
                            </td>

                            <td>
                                16 Oktober 2019
                            </td>
                            <td class="completion">
                                Pendidikan, Hukum
                            </td>
                            <td class="status">
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-success"></i> terbit
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" href="#">Hapus</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br><br>
            </div>
        </div>
    </div>
</div>
@endsection
