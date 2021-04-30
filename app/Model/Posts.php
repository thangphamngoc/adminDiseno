<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //
    protected $table = 'posts';
    protected $fillable = [
    ];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'ex_post_image');
    }
}
