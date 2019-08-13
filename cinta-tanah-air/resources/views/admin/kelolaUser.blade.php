@extends('layouts.adminPanel')
@section('title', 'Kelola User')
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
        @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-bell-55"></i></span>
            <span class="alert-inner--text"> {{ Session::get('status') }}</span>
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

                <div>
                    <table id="users_table" class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">
                                    Id
                                </th>
                                <th scope="col">
                                    Nama
                                </th>
                                <th scope="col">
                                    Email
                                </th>
                                <th scope="col">
                                    Akses
                                </th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{ $user->id }}
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    @if ($user->role == 1)
                                    <div class="text-danger">
                                        Admin
                                    </div>
                                    @else
                                    <div class="text-primary">
                                        Author
                                    </div>
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
                                                href="{{ url('admin/edit-user') . '/' . $user->id }}">Edit</a>
                                            <a class="dropdown-item"
                                                href="{{ url('admin/delete-user') . '/' . $user->id }}">Hapus</a>
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
