<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use App\Article;
use App\ArticleCategory;
use App\ArticleStatistic;

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
    public function countStat()
    {
        $top_3_articles = Article::where('status', 1)->get()->take(3);

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

    public function pushStat($article_id)
    {
        $client_ip = $this->getUserIpAddr();
        $check = ArticleStatistic::where([['article_id', $article_id], ['viewer_ip', $client_ip]])->first();

        if($check == null){
            $art_stat = new ArticleStatistic();
            $art_stat->article_id = $article_id;
            $art_stat->viewer_ip = $client_ip;
            $art_stat->save();
        }
    }

    public function showHome()
    {
        $articles = Article::where('status', 1)->get();
        $stat = $this->countStat();

        return view('home', ['stat' => $stat, 'articles' => $articles]);
    }

    public function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function showBerita()
    {
        $articles = Article::where([['type', 'berita'], ['status', 1]])->paginate(5);
        $stat = $this->countStat();

        return view('home.berita', ['category' => 'Terkini', 'articles' => $articles,  'stat' => $stat]);
    }

    public function showBeritaCategory($category)
    {

        $articles = Article::where([['type', 'berita'], ['status', 1]])->whereHas('category', function (Builder $query) use ($category) {
            $query->where('category', $category);
        })->paginate(5);

        $stat = $this->countStat();

        return view('home.berita', ['category' => $category, 'articles' => $articles, 'stat' => $stat]);
    }

    public function openArticle($slug)
    {
        $article = Article::where('slug', $slug)->first();

        // Posted Validate
        if($article->status != 1){
            return abort(404);
        }

        // Push Article Statistic
        $this->pushStat($article->id);

        $stat = $this->countStat();

        return view('home.openArtikel', ['article' => $article, 'stat' => $stat]);
    }

    public function showBertutur()
    {
        $articles = Article::where([['type', 'bertutur'], ['status', 1]])->paginate(5);

        $stat = $this->countStat();

        return view('home.bertutur', ['category' => 'Terkini',  'articles' => $articles, 'stat' => $stat]);
    }

    public function cariArtikel(Request $request)
    {
        $articles = Article::where('title', 'like', $request->search)->paginate(5);
        $stat = $this->countStat();

        return view('home.berita', ['category' => $request->search, 'articles' => $articles,  'stat' => $stat]);
    }

    public function showProfil()
    {
        $stat = $this->countStat();

        return view('home.profil', ['stat' => $stat]);
    }

    /// Logout Function
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
