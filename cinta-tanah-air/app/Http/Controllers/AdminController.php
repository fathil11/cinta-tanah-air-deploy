<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Image;
use File;
use Auth;

use App\User;
use App\Article;
use App\ArticleCategory;
use App\ArticleStatistic;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{
    use UploadTrait;

    public function showWelcome()
    {
        return view('admin.welcome');
    }

    public function catStat()
    {
        $category_set = ['budaya', 'pemberdayaan', 'pendidikan', 'sosial', 'hukum'];

        foreach ($category_set as $cat_srch) {
            $cat_stat[$cat_srch] = count(ArticleCategory::where('category', $cat_srch)->get());
        }

        return $cat_stat;
    }

    public function artStat()
    {
        $articles = Article::where('status', 1)->whereDate('created_at', date("Y-m-d"))->take(3)->get();
        return $articles;
    }

    public function showStatistic()
    {
        $article_count = count(Article::all());
        $article_per_day_count = count(Article::whereDate('created_at', date("Y-m-d"))->get());
        $view_per_day_count = count(ArticleStatistic::select('viewer_ip')->whereDate('created_at', date("Y-m-d"))->distinct()->get());
        $article_postponed_count = count(Article::where('status', 3)->get());
        $article_postponed_per_day_count = count(Article::where('status', 3)->whereDate('created_at', date("Y-m-d"))->get());
        $comment = '-';

        $stat['article_count'] = $article_count;
        $stat['article_per_day_count'] = $article_per_day_count;
        $stat['view_per_day_count'] = $view_per_day_count;
        $stat['article_postponed_count'] = $article_postponed_count;
        $stat['article_postponed_per_day_count'] = $article_postponed_per_day_count;
        $stat['comment'] = $comment;

        return view('admin.statistik', ['stat' => $stat]);
    }

    public function showBuatArtikel()
    {
        return view('admin.buatArtikel');
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
        $article->status = 1;

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
        return redirect(url('admin/kelola-artikel'))->with('success', 'Artikel berhasil dibuat.');
    }

    public function showKelolaArtikel()
    {
        $articles = Article::where('status', '1')->get();

        return view('admin.kelolaArtikel', ['articles' => $articles]);
    }

    public function showDraftArtikel()
    {
        $articles = Article::where('status', '2')->orWhere('status', '3')->get();
        return view('admin.draftArtikel', ['articles' => $articles]);
    }

    // Terbitkan Artikel
    public function terbitArtikel($id)
    {
        $article = Article::find($id);
        $article->status = 1;
        if ($article->save()) {
            return redirect(url('admin/kelola-artikel'))->with('sucess', 'Artikel berhasil diterbitkan');
        }
    }


    // Show Edit Artikel
    public function showEditArtikel($id)
    {
        $article = Article::find($id);
        if($article->status == 1){
            return redirect(url('admin/kelola-artikel'))->with('error', 'Artikel sudah diterbitkan, tidak bisa di edit.');
        }
        return view('admin.editArtikel', ['article' => $article]);
    }
    // Edit Artikel
    public function editArtikel(Request $request, $id)
    {
        $article = Article::find($id);

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

        return redirect(url('admin/draft-artikel'))->with('success', 'Artikel berhasil di edit.');
    }

    public function tolakArtikel($id)
    {
        $article = Article::findOrFail($id);

        if($article->status == 1){
            return abort(404);
        }

        $article->status = 4;
        if($article->save()){
            return redirect(url('admin/draft-artikel'))->with('success', 'Artikel berhasil ditolak');
        }
    }
    // Buat User
    public function showBuatUser()
    {
        return view('admin.buatUser');
    }

    public function buatUser(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|unique:users,email',
            'moto' => 'max:100',
            'profile_picture' => 'bail|image|mimes:jpeg,png,jpg,gif|max:10000',
            'password' => 'sometimes|min:8',
            'password_confirmation' => 'sometimes|same:password',
            'role' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->moto = $request->moto;

        if ($request->role == 'admin') {
            $user->role = 1;
        } elseif ($request->role == 'author') {
            $user->role = 2;
        }

        if ($request->has('profile_picture')) {
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
            return redirect(url('admin/kelola-user'))->with('success', 'Berhasil mendaftarkan user');
        }
    }

    public function showKelolaUser()
    {
        $users = User::all();
        return view('admin.kelolaUser', ['users' => $users]);
    }

    public function showEditUser($id)
    {
        $user = User::find($id);
        return view('admin.editUser', ['user' => $user]);
    }

    public function editUser(Request $request, $id)
    {
        $user = User::find($id);

        if ($request->email == $user->email) {
            $request->validate([
                'name' => 'required|min:3|max:50',
                'moto' => 'max:100',
                'password' => 'nullable|min:8',
                'password_confirmation' => 'nullable|same:password',
                'role' => 'required',
            ]);
        } else {
            $request->validate([
                'name' => 'required|min:3|max:50',
                'email' => 'required|unique:users,email',
                'moto' => 'max:100',
                'password' => 'nullable|min:8',
                'password_confirmation' => 'nullable|same:password',
                'role' => 'required',
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

        if ($request->role == 'admin') {
            $user->role = 1;
        } elseif ($request->role == 'author') {
            $user->role = 2;
        }

        if ($user->save()) {
            return redirect(url('admin/kelola-user'))->with('success', 'Berhasil di update.');
        }
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            return redirect(url('admin/kelola-user'));
        }
    }

    public function showProfil()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('admin.profil', ['user' => $user]);
    }

    public function editProfil(Request $request )
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
            return redirect(url('admin/profil'))->with('success', 'Berhasil di update.');
        }
    }

    public function showTinjauArtikel($id)
    {
        $article = Article::findOrFail($id);

        if($article->status != 2 && $article->status != 3){
            return abort(404);
        }

        $article->status = 2;
        $article->save();

        $cat_stat = $this->catStat();
        $art_stat = $this->artStat();

        return view('admin.tinjauArtikel', ['article' => $article, 'cat_stat' => $cat_stat, 'art_stat' => $art_stat]);
    }
}
