<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function showWelcome()
    {
        return view('author.welcome');
    }

    public function showProfil()
    {
        return view('author.profil');
    }
    public function showBuatArtikel()
    {
        return view('author.buatArtikel');
    }

    public function showKelolaArtikel()
    {
        return view('author.kelolaArtikel');
    }
}
