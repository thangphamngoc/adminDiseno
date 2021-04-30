<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $table = 'images';
    protected $fillable = [
    ];

    public function projectsDetail()
    {
        return $this->belongsToMany(projectsDetail::class, 'ex_project_detail_image');
    }
    public function news()
    {
        return $this->belongsToMany(News::class, 'ex_new_image');
    }
    public function posts()
    {
        return $this->belongsToMany(Posts::class, 'ex_post_image');
    }
    public function newItem()
    {
        return $this->belongsToMany(NewItems::class, 'ex_new_item_image');
    }
    public function abouts()
    {
        return $this->belongsToMany(Abouts::class, 'ex_about_image');
    }
    public function contacts()
    {
        return $this->belongsToMany(Contacts::class, 'ex_contact_image');
    }
}
