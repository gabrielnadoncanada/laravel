<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['id', 'name'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
