<?php

namespace App;

use App\Article as Article;
use Illuminate\Database\Eloquent\Model;

class ArticleStatistic extends Model
{
    protected $table = "article_statistic";

    public function article(){
        $this->belongsTo('Article', 'article_id');
    }
}
