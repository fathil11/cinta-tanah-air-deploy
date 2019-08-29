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

    public function dayTranslator($day)
    {
        if($day == 'Sunday'){
            return 'Minggu';
        }elseif($day == 'Monday'){
            return 'Senin';
        }elseif($day == 'Tuesday'){
            return 'Selasa';
        }elseif($day == 'Wednesday'){
            return 'Rabu';
        }elseif($day == 'Thursday'){
            return 'Kamis';
        }elseif($day == 'Friday'){
            return 'Jumat';
        }elseif($day == 'Saturday'){
            return 'Sabtu';
        }
    }
    public function showWelcome()
    {
        $stat = $this->countStat();

        return view('admin.welcome', ['stat' => $stat]);
    }

    public function countStat()
    {
        $top_3_articles = Article::where('status', 1)->whereDate('created_at', date("Y-m-d"))->take(3)->get();

        $article_count = count(Article::all());

        $article_per_day_count = count(Article::whereDate('created_at', date("Y-m-d"))->get());

        $article_postponed_count = count(Article::where('status', 3)->get());

        $article_postponed_per_day_count = count(Article::where('status', 3)->whereDate('created_at', date("Y-m-d"))->get());

        $category_set = ['budaya', 'pemberdayaan', 'pendidikan', 'sosial', 'hukum'];
        foreach ($category_set as $cat_srch) {
            $cat_article_count[$cat_srch] = count(ArticleCategory::where('category', $cat_srch)->get());
        }

        $view_per_day_count = count(ArticleStatistic::select('viewer_ip')->whereDate('created_at', date("Y-m-d"))->distinct()->get());

        $comment_count = '-';

        $comment_per_day_count = '-';

        $stat['top_3_articles'] = $top_3_articles;
        $stat['article_count'] = $article_count;
        $stat['article_per_day_count'] = $article_per_day_count;
        $stat['article_postponed_count'] = $article_postponed_count;
        $stat['article_postponed_per_day_count'] = $article_postponed_per_day_count;
        $stat['cat_article_count'] = $cat_article_count;
        $stat['view_per_day_count'] = $view_per_day_count;
        $stat['comment_count'] = $comment_count;
        $stat['comment_per_day_count'] = $comment_per_day_count;

        return $stat;
    }

    public function showStatistic()
    {
        $stat = $this->countStat();
        $spec_stat['today_art'] = count(Article::whereDate('created_at', Carbon::today())->get());
        $spec_stat['h-1_art'] = count(Article::whereDate('created_at', Carbon::today()->subDays(1))->get());
        $spec_stat['h-2_art'] = count(Article::whereDate('created_at', Carbon::today()->subDays(2))->get());
        $spec_stat['h-3_art'] = count(Article::whereDate('created_at', Carbon::today()->subDays(3))->get());
        $spec_stat['h-4_art'] = count(Article::whereDate('created_at', Carbon::today()->subDays(4))->get());
        $spec_stat['h-5_art'] = count(Article::whereDate('created_at', Carbon::today()->subDays(5))->get());
        $spec_stat['h-6_art'] = count(Article::whereDate('created_at', Carbon::today()->subDays(6))->get());

        $spec_stat['today'] = $this->dayTranslator(Carbon::today()->format('l'));
        $spec_stat['h-1'] = $this->dayTranslator(Carbon::today()->subDays(1)->format('l'));
        $spec_stat['h-2'] = $this->dayTranslator(Carbon::today()->subDays(2)->format('l'));
        $spec_stat['h-3'] = $this->dayTranslator(Carbon::today()->subDays(3)->format('l'));
        $spec_stat['h-5'] = $this->dayTranslator(Carbon::today()->subDays(5)->format('l'));
        $spec_stat['h-4'] = $this->dayTranslator(Carbon::today()->subDays(4)->format('l'));
        $spec_stat['h-6'] = $this->dayTranslator(Carbon::today()->subDays(6)->format('l'));

        $article = Article::with('statistic')->withCount('statistic')->orderBy('article_id', 'desc')->get();
        dd($article);
        return view('admin.statistik', ['stat' => $stat, 'spec_stat' => $spec_stat]);
    }

    public function showBuatArtikel()
    {
        $stat = $this->countStat();
        return view('admin.buatArtikel', ['stat' => $stat]);
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

        $stat = $this->countStat();
        return view('admin.kelolaArtikel', ['articles' => $articles, 'stat' => $stat]);
    }

    public function showDraftArtikel()
    {
        $articles = Article::where('status', '2')->orWhere('status', '3')->get();
        $stat = $this->countStat();

        return view('admin.draftArtikel', ['articles' => $articles, 'stat' => $stat]);
    }

    // Terbitkan Artikel
    public function terbitArtikel($id)
    {
        $article = Article::findOrFail($id);
        $article->status = 1;
        if ($article->save()) {
            return redirect(url('admin/kelola-artikel'))->with('sucess', 'Artikel berhasil diterbitkan');
        }
    }


    // Show Edit Artikel
    public function showEditArtikel($id)
    {
        $article = Article::findOrFail($id);
        if($article->status == 1){
            return redirect(url('admin/kelola-artikel'))->with('error', 'Artikel sudah diterbitkan, tidak bisa di edit.');
        }

        $stat = $this->countStat();
        return view('admin.editArtikel', ['article' => $article, 'stat' => $stat]);
    }
    // Edit Artikel
    public function editArtikel(Request $request, $id)
    {
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
        $article->status = 3;

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
        $stat = $this->countStat();
        return view('admin.buatUser', ['stat' => $stat]);
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
        $stat = $this->countStat();

        return view('admin.kelolaUser', ['users' => $users, 'stat' => $stat]);
    }

    public function showEditUser($id)
    {
        $user = User::findOrFail($id);
        $stat = $this->countStat();

        return view('admin.editUser', ['user' => $user, 'stat' => $stat]);
    }

    public function editUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

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
        $user = User::findOrFail($id);
        if ($user->delete()) {
            return redirect(url('admin/kelola-user'));
        }
    }

    public function showProfil()
    {
        $user = User::findOrFail(Auth::user()->id);
        $stat = $this->countStat();

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

        $stat = $this->countStat();

        return view('admin.tinjauArtikel', ['article' => $article, 'stat' => $stat]);
    }
}
