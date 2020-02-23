<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    protected $table = "replies";
    protected $fillable = ['user_id', 'thread_id', 'user_parent_id', 'body'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($reply){
            $reply->user_id = auth()->id;
        });
    }


    // relationships

    public function User()
    {
        $this->belongsTo(User::class, 'user_id');
    }

    public function Thread()
    {
        $this->belongsTo(Thread::class, 'thread_id');
    }

    public function Likes()
    {
        $this->hasMany(Like::class);
    }
}
