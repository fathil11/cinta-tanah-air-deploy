<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    protected $table = 'comment_reply';

    public function parentComment()
    {
        $this->belongsTo('ArticleComment', 'comment_id');
    }
}
