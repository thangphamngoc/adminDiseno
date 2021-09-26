<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    //
    protected $table = 'projects';
    protected $fillable = [
        "title",
        "titleEn",
        "content",
        "contentEn",
        "titlePicture",
        "titlePictureEn",
        "create_by",
        "id_create",
        "urlPicture",
        "namePicture",
        "ulrLocal",
        "type",
        "address",
        "descreption",
        "slud",
    ];

    public function projectDetail()
    {
        return $this->belongsToMany('App\Model\ProjectDetail');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'ex_project_image');
    }
}
