<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SaveThread extends Model
{
    protected $table = 'save_threads';
    protected $fillable = ['user_id', 'thread_id'];


    // Relationships

    public function User()
    {
      return $this->belongsTo(User::class, 'user_id');
    }


    public function Thread()
    {
       return $this->belongsTo(Thread::class, 'thread_id');
    }


    public static function UpdateRow($userID, $threadID)
    {

    }
}
