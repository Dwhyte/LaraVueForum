<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    protected $table = "replies";
    protected $fillable = ['user_id', 'thread_id', 'parent_id', 'body'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($reply){
            $reply->user_id = auth()->user()->id;
        });
    }


    // relationships

    public function User()
    {
       return $this->belongsTo(User::class, 'user_id');
    }

    public function Thread()
    {
       return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function Likes()
    {
       return $this->hasMany(Like::class, 'reply_id');
    }

    public function Comments()
    {
        return $this->hasMany(Replies::class, 'parent_id');
    }
}
