<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thread extends Model
{
    protected $table = "threads";
    protected $fillable = ["user_id", "cat_id", "username", "slug", "title", "content", "featured_image", "isDrafted"];
    protected $with = ['replies'];



    protected static function boot()
    {
        parent::boot(); // gets all the function related to parent boot class - Model.php

        static::creating(function($thread){
            $thread->slug = Str::slug($thread->slug);
        });
    }


    public function getRouteKeyName()
    {
        return "slug";
    }

    public function getPathAttribute()
    {
        return "/thread/$this->username/$this->slug";
    }


    // relationships

    public function User()
    {
        $this->belongsTo(User::class, 'user_id');
    }

    public function Category()
    {
        $this->belongsTo(Category::class, 'cat_id');
    }

    public function Replies()
    {
        $this->hasMany(Replies::class)->latest();
    }
}
