<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id'];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
