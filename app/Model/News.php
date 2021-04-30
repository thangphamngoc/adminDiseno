<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $table = 'news';
    protected $fillable = [
    ];


    public function images()
    {
        return $this->belongsToMany(Image::class, 'ex_new_image');
    }
}
