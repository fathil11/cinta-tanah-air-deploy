<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth as IlluminateAuth;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Image;
use File;
use Auth;

use App\User;
use App\Article;
use App\ArticleCategory;

class AuthorController extends Controller
{
    use UploadTrait;

    public function showWelcome()
    {
        return view('author.welcome');
    }

    public function showBuatArtikel()
    {
        return view('author.buatArtikel');
    }

    public function buatArtikel(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5|max:50',
            'banner_path' => 'bail|image|mimes:jpeg,png,jpg,gif|max:10000',
            'article_type' => 'required',
            'cat' => 'nullable',
            'editor' => 'bail|required|min:10|max:10000'
        ]);

        $article = new Article();
        $article->author_id = Auth::user()->id;
        $article->title = $request->title;
        $article->slug = str_slug($request->title, '-');
        $article->type = $request->article_type;
        $article->article = $request->editor;
        $article->status = 3;

        if ($request->has('banner_path')) {
            // Get image file
            $image = $request->file('banner_path');
            // Make a image name based on user name and current timestamp
            $name = str_slug($request->input('title')) . '_' . time();
            // Define folder path
            $folder = 'img/blog/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder .  $name . '.' . $image->getClientOriginalExtension();

            // Upload image
            if ($this->uploadOne($image, $folder, 'public', $name)) {
                // Crop
                $img = Image::make(public_path($filePath));
                $croppath = public_path($filePath);

                $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));

                $img->save($croppath);
            }

            $article->banner_path = $name . '.' . $image->getClientOriginalExtension();
        }

        $article->save();
        if ($request->has('cat')) {
            foreach ($request->cat as $ca) {
                $new_cat = new ArticleCategory();
                $new_cat->article_id = $article->id;
                $new_cat->category = $ca;
                $new_cat->save();
            }
        }
        return redirect(url('author/kelola-artikel'))->with('status', 'Artikel berhasil dibuat.');
    }

    public function showKelolaArtikel()
    {
        $articles = Article::where('author_id', Auth::user()->id)->get();
        return view('author.kelolaArtikel', ['articles' => $articles]);
    }

    public function lihatArtikel($id)
    {
        $article = Article::findOrFail($id);

        $stat = $this->countStat();

        return view('author.lihatArtikel', ['article' => $article, 'stat' => $stat]);
    }

    public function showEditArtikel($id)
    {
        $article = Article::findOrFail($id);
        // Validasi Pembuat Artikel
        if($article->author_id != Auth::user()->id){
            return redirect(url('author/kelola-artikel'))->with('error', 'Artikel bukan buatan anda, tidak bisa di edit.');
        }

        // Validasi Status Artikel
        if($article->status == 1){
            return redirect(url('author/kelola-artikel'))->with('error', 'Artikel sudah diterbitkan, tidak bisa di edit.');
        }elseif($article->status == 2){
            return redirect(url('author/kelola-artikel'))->with('error', 'Artikel sedang ditinjau, tidak bisa di edit.');
        }

        session(['update_checker' => $article->id]);
        return view('author.editArtikel', ['article' => $article]);
    }

    public function editArtikel(Request $request, $id)
    {
        $update_checker = $request->session()->get('update_checker');

        if($id != $update_checker){
            return redirect(url('author/kelola-artikel'))->with('error', 'Terjadi kesalahan.');
        }

        $request->session()->forget('update_checker');

        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|min:5|max:50',
            'banner_path' => 'bail|image|mimes:jpeg,png,jpg,gif|max:10000',
            'article_type' => 'required',
            'cat' => 'nullable',
            'editor' => 'bail|required|min:30|max:10000'
        ]);
        $article->title = $request->title;
        $article->slug = str_slug($request->title, '-');
        $article->type = $request->article_type;
        $article->article = $request->editor;

        if ($request->has('banner_path')) {
            // Get image file
            $image = $request->file('banner_path');
            // Make a image name based on user name and current timestamp
            $name = str_slug($request->input('title')) . '_' . time();
            // Define folder path
            $folder = 'img/blog/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            if ($this->uploadOne($image, $folder, 'public', $name)) {
                // Crop
                $img = Image::make(public_path($filePath));
                $croppath = public_path($filePath);

                $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));

                $img->save($croppath);
            }

            $article->banner_path = $name . '.' . $image->getClientOriginalExtension();
        }

        $article->save();

        $cat_clear = ArticleCategory::where('article_id', $id);
        $cat_clear->delete();

        foreach ($request->cat as $ca) {
            $new_cat = new ArticleCategory();
            $new_cat->article_id = $article->id;
            $new_cat->category = $ca;
            $new_cat->save();
        }

        return redirect(url('author/kelola-artikel'))->with('success', 'Artikel berhasil di edit.');
    }


    public function showProfil()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('author.profil', ['user' => $user]);
    }

    public function editProfil(Request $request)
    {

        $user = User::findOrFail(Auth::user()->id);

        if ($request->email == $user->email) {
            $request->validate([
                'name' => 'required|min:3|max:50',
                'moto' => 'max:100',
                'password' => 'nullable|min:8',
                'password_confirmation' => 'nullable|same:password',
            ]);
        } else {
            $request->validate([
                'name' => 'required|min:3|max:50',
                'email' => 'required|unique:users,email',
                'moto' => 'max:100',
                'password' => 'nullable|min:8',
                'password_confirmation' => 'nullable|same:password',
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->moto = $request->moto;

        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }

        if($request->has('profile_picture')){
            // Get image file
            $image = $request->file('profile_picture');
            // Make a image name based on user name and current timestamp
            $name = str_slug($request->input('name')) . '_' . time();
            // Define folder path
            $folder = 'img/user_picture/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            if ($this->uploadOne($image, $folder, 'public', $name)) {
                // Crop
                $img = Image::make(public_path($filePath));
                $croppath = public_path($filePath);

                $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));

                $img->save($croppath);
            }

            $user->profile_picture = $name . '.' . $image->getClientOriginalExtension();
        }

        if ($user->save()) {
            return redirect(url('author/profil'))->with('success', 'Berhasil di update.');
        }

    }

    public function deleteArtikel($id)
    {
        $article = Article::findOrFail($id);

        // Validasi Pembuat Artikel
        if($article->author_id != Auth::user()->id){
            return redirect(url('author/kelola-artikel'))->with('error', 'Artikel bukan buatan anda, tidak bisa di delete.');
        }

        // Validasi Status Artikel
        if($article->status == 1){
            return redirect(url('author/kelola-artikel'))->with('error', 'Artikel sudah diterbitkan, tidak bisa di delete.');
        }elseif($article->status == 2){
            return redirect(url('author/kelola-artikel'))->with('error', 'Artikel sedang ditinjau, tidak bisa di delete.');
        }

        $article->delete();

        return redirect(url('author/kelola-artikel'))->with('success', 'Artikel berhasil di delete.');
    }
}
