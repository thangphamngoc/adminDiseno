<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Abouts extends Model
{
    //
    protected $table = 'abouts';
    protected $fillable = [
    ];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'ex_about_image');
    }
}
