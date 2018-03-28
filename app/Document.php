<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'path', 'thumbnailPath'];
    protected $hidden = ['path', 'thumbnailPath', 'updated_at', 'created_at'];

}
