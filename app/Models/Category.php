<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $fillable = ["name", "slug", 'color'];


    // relationships

    public function Threads()
    {
      return $this->hasMany(Thread::class, 'cat_id');
    }
}
