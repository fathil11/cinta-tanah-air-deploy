<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    protected $table = 'article_comment';

    public function article()
    {
        $this->belongsTo('Article', 'article_id');
    }

    public function reply()
    {
        $this->hasMany('CommentReply', 'comment_id');
    }

}
