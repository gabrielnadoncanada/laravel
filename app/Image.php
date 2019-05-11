<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['location_id', 'name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image_user()
    {
        return $this->belongsTo(Image_user::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('alert');
    }
}

