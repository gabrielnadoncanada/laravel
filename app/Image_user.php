<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Image_user extends Model
{   
    protected $table = 'Image_user';
    protected $fillable = ['alert', 'user_id', 'image_id'];
}
