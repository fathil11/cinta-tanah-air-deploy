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
});

/// Admin Route
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    // Show Welcome
    Route::get('', 'AdminController@showWelcome');
    Route::get('welcome', 'AdminController@showWelcome');

    // Show Statistik
    Route::get('statistik', 'AdminController@showStatistic');

    // Show Buat Artikel
    Route::get('buat-artikel', 'AdminController@showBuatArtikel');

    // Buat Artikel
    Route::post('buat-artikel', 'AdminController@buatArtikel');

    // Show Kelola Artikel
    Route::get('kelola-artikel', 'AdminController@showKelolaArtikel');

    // Terbitkan Artikel
    Route::get('terbit-artikel/{id}', 'AdminController@terbitArtikel');

    // Tunda Artikel
    Route::get('tunda-artikel/{id}', 'AdminController@tundaArtikel');

    // Show Edit Artikel
    Route::get('edit-artikel/{id}', 'AdminController@showEditArtikel');

    // Edit Artikel
    Route::post('edit-artikel/{id}', 'AdminController@editArtikel');

    // Delete Artikel
    Route::get('hapus-artikel/{id}', 'AdminController@deleteArtikel');

    // Show Draft Artikel
    Route::get('draft-artikel', 'AdminController@showDraftArtikel');

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

    // Show Edit Artikel
    Route::get('edit-artikel/{id}', 'AuthorController@showEditArtikel');

    // Edit Artikel
    Route::post('edit-artikel/{id}', 'AuthorController@editArtikel');

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
