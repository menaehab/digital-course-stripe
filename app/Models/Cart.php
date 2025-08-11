<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Cashier;

class Cart extends Model
{
    protected $guarded = ['id'];

    protected $with = ['courses'];

    public function scopeSession($query)
    {
        return $query->where('session_id', session()->getId());
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function total()
    {
        return Cashier::formatAmount($this->courses()->sum('price'), env('CASHIER_CURRENCY'));
    }
}
