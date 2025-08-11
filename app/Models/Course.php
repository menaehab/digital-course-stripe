<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = ['id'];

    public function cart()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}