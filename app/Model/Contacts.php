<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    //
    protected $table = 'contacts';
    protected $fillable = [
    ];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'ex_contact_image');
    }
}
