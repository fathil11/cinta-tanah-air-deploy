<?php

namespace App;

use App\User as User;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    protected $table = "user_messages";

    public function userSender(){
        return $this->belongsTo('User', 'sender_id');
    }

    public function userRecieved(){
        return $this->belongsTo('User', 'recipient_id');
    }
}
