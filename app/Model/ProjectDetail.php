<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    //
    protected $table = 'project_details';
    protected $fillable = [
    ];

    public function project(){
        return $this->hasOne('App\Model\Projects');
    }
}
