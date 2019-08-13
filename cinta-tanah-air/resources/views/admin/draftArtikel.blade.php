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
        <div class="card shadow cardcustom">
            <div class="container">
                <br>
                <div>
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
                                    Penulis
                                </th>
                                <th scope="col">
                                    Kategori
                                </th>
                                <th scope="col">
                                    Tanggal
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
                                    Megawati Ambil Sumpah Jabatan Ketum PDIP 2019-2024
                                </td>
                                <td class="status">
                                    Fakhri RJ
                                </td>
                                <td class="completion">
                                    Politik
                                </td>
                                <td>
                                    15 Agustus 2019
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="#">Terbitkan</a>
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
                                    Sederet Cerita Unik di Balik Kongres V PDIP
                                </td>
                                <td class="status">
                                    Juniar Firmansyah
                                </td>
                                <td class="completion">
                                    Pendidikan
                                </td>
                                <td>
                                    31 Februari 2019
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="#">Terbitkan</a>
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Hapus</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
                <br><br>
            </div>
        </div>
    </div>
</div>
@endsection
