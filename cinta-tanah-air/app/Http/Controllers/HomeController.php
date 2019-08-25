<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use App\Article;
use App\ArticleCategory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showHome()
    {
        // dd(public_path());
        $art_stat = $this->artStat();

        return view('home.home', ['art_stat' => $art_stat]);
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

    public function showBerita()
    {
        $articles = Article::where([['type', 'berita'], ['status', 1]])->paginate(5);
        $cat_stat = $this->catStat();
        $art_stat = $this->artStat();

        return view('home.berita', ['category' => 'Terkini', 'cat_stat' => $cat_stat, 'art_stat' => $art_stat, 'articles' => $articles]);
    }

    public function showBeritaCategory($category)
    {

        $articles = Article::where([['type', 'berita'], ['status', 1]])->whereHas('category', function (Builder $query) use ($category) {
            $query->where('category', $category);
        })->paginate(5);
        $cat_stat = $this->catStat();

        $art_stat = $this->artStat();
        return view('home.berita', ['category' => $category, 'cat_stat' => $cat_stat, 'art_stat' => $art_stat, 'articles' => $articles]);
    }

    public function openArticle($slug)
    {
        $article = Article::where('slug', $slug)->first();
        if($article->status != 1){
            return abort(404);
        }
        $cat_stat = $this->catStat();
        $art_stat = $this->artStat();
        return view('home.openArtikel', ['article' => $article, 'cat_stat' => $cat_stat, 'art_stat' => $art_stat]);
    }

    public function showBertutur()
    {
        $articles = Article::where([['type', 'bertutur'], ['status', 1]])->paginate(5);
        // dd($articles);
        $cat_stat = $this->catStat();
        $art_stat = $this->artStat();

        return view('home.bertutur', ['category' => 'Terkini', 'cat_stat' => $cat_stat, 'art_stat' => $art_stat, 'articles' => $articles]);
    }

    public function showProfil()
    {
        $cat_stat = $this->catStat();
        $art_stat = $this->artStat();
        return view('home.profil', ['cat_stat' => $cat_stat, 'art_stat' => $art_stat]);
    }

    /// Logout Function
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
