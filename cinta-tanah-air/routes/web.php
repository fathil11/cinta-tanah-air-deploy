<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/// Public Route
Route::group(['prefix' => '/'], function () {
    /// Show Home
    Route::get('', 'HomeController@showHome');

    // Show Berita All
    Route::get('berita', 'HomeController@showBerita');

    // Show Berita Ketegori
    Route::get('berita/{category}', 'HomeController@showBeritaCategory');

    // Show Bertutur
    Route::get('bertutur', 'HomeController@showBertutur');

    // Show Open Artikel
    Route::get('lihat-artikel/{slug}', 'HomeController@openArticle');

    // Show Profil
    Route::get('profil', 'HomeController@showProfil');

    // Cari Berita
    Route::post('cari-artikel', 'HomeController@cariArtikel');
});

/// Admin Route
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    // Show Welcome
    Route::get('', 'AdminController@showWelcome');

    // Show Statistik
    Route::get('statistik', 'AdminController@showStatistic');

    // Show Buat Artikel
    Route::get('buat-artikel', 'AdminController@showBuatArtikel');

    // Buat Artikel
    Route::post('buat-artikel', 'AdminController@buatArtikel');

    // Show Kelola Artikel
    Route::get('kelola-artikel', 'AdminController@showKelolaArtikel');

    // Show Draft Artikel
    Route::get('draft-artikel', 'AdminController@showDraftArtikel');

    // Show Tinjau Artikel
    Route::get('tinjau-artikel/{id}', 'AdminController@showTinjauArtikel');

    // Show Edit Artikel
    Route::get('edit-artikel/{id}', 'AdminController@showEditArtikel');

    // Edit Artikel
    Route::post('edit-artikel/{id}', 'AdminController@editArtikel');

    // Terbitkan Artikel
    Route::get('terbit-artikel/{id}', 'AdminController@terbitArtikel');

    // Tolak Artikel
    Route::get('tolak-artikel/{id}', 'AdminController@tolakArtikel');

    // Show Kelola User
    Route::get('kelola-user', 'AdminController@showKelolaUser');

    // Show Edit User
    Route::get('edit-user/{id}', 'AdminController@showEditUser');

    // Edit User
    Route::put('edit-user/{id}', 'AdminController@editUser');

    // Delete User
    Route::get('delete-user/{id}', 'AdminController@deleteUser');

    // Show Buat User
    Route::get('buat-user', 'AdminController@showBuatUser');

    // Buat User
    Route::post('buat-user', 'AdminController@buatUser');

    // Show Profil
    Route::get('profil', 'AdminController@showProfil');

    // Edit Profil
    Route::post('edit-profil', 'AdminController@editProfil');
});

/// Author Route
Route::group(['prefix' => 'author', 'middleware' => 'author'], function () {
    // Show Welcome
    Route::get('', 'AuthorController@showWelcome');
    Route::get('welcome', 'AuthorController@showWelcome');

    // Show Buat Artikel
    Route::get('buat-artikel', 'AuthorController@showBuatArtikel');

    // Buat Artikel
    Route::post('buat-artikel', 'AuthorController@buatArtikel');

    // Show Kelola Artikel
    Route::get('kelola-artikel', 'AuthorController@showKelolaArtikel');

    // Show Lihat Artikel
    Route::get('lihat-artikel/{id}', 'AuthorController@lihatArtikel');

    // Show Edit Artikel
    Route::get('edit-artikel/{id}', 'AuthorController@showEditArtikel');

    // Edit Artikel
    Route::post('edit-artikel/{id}', 'AuthorController@editArtikel');

    // Edit Artikel
    Route::get('delete-artikel/{id}', 'AuthorController@deleteArtikel');

    // Show Profil
    Route::get('profil', 'AuthorController@showProfil');

    // Edit Profil
    Route::post('edit-profil', 'AuthorController@editProfil');
});

Auth::routes();

/// Login Route
Route::get('login', function () {
    return view('home.login');
});

/// Logout Route
Route::get('logout', 'HomeController@logout');


// Route::get('/home', 'HomeController@index')->name('home');
