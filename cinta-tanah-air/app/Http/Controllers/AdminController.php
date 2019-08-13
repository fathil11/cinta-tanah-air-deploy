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
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{
    use UploadTrait;

    public function showWelcome()
    {
        return view('admin.welcome');
    }

    public function showStatistic()
    {
        return view('admin.statistik');
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
            $filePath = $folder . '/' . $name . '.' . $image->getClientOriginalExtension();

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
        return redirect(url('admin/kelola-artikel'))->with('status', 'Artikel berhasil dibuat.');
    }

    public function showKelolaArtikel()
    {
        $articles = Article::all();

        return view('admin.kelolaArtikel', ['articles' => $articles]);
    }

    public function showDraftArtikel()
    {
        return view('admin.draftArtikel');
    }

    // Terbitkan Artikel
    public function terbitArtikel($id)
    {
        $article = Article::find($id);
        $article->status = 1;
        if ($article->save()) {
            return redirect(url('admin/kelola-artikel'))->with('status', 'Artikel berhasil diterbitkan');
        }
    }

    // Tunda Artikel
    public function tundaArtikel($id)
    {
        $article = Article::find($id);
        $article->status = 2;
        if ($article->save()) {
            return redirect(url('admin/kelola-artikel'))->with('status', 'Artikel berhasil ditunda');
        }
    }

    // Show Edit Artikel
    public function showEditArtikel($id)
    {
        $article = Article::find($id);
        return view('admin.editArtikel', ['article' => $article]);
    }
    // Edit Artikel
    public function editArtikel(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|min:5|max:50',
            'banner_path' => 'bail|image|mimes:jpeg,png,jpg,gif|max:10000',
            'article_type' => 'required',
            'cat' => 'nullable',
            'editor' => 'bail|required|min:30|max:10000'
        ]);
        $article = Article::find($id);
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

        return redirect(url('admin/kelola-artikel'))->with('status', 'Artikel berhasil di edit.');
    }

    public function deleteArtikel($id)
    {
        $article = Article::find($id);
        $article->delete();
        return redirect(url('admin/kelola-artikel'))->with('status', 'Artikel berhasil di hapus.');
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
            return redirect(url('admin/kelola-user'))->with('status', 'Berhasil mendaftarkan user');
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

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->role == 'admin') {
            $user->role = 1;
        } elseif ($request->role == 'author') {
            $user->role = 2;
        }

        if ($user->save()) {
            return redirect(url('admin/kelola-user'))->with('status', 'Berhasil di update.');
        }
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            return redirect(url('admin/kelola-user'));
        }
    }
}
