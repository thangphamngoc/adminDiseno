<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Homes extends Model
{
    //
    protected $table = 'homes';
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
        "sort",
    ];
}
