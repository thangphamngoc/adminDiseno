<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NewItems extends Model
{
    //
    protected $table = 'new_items';
    protected $fillable = [
    ];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'ex_new_item_image');
    }
}
