<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function genre()
    {
        return $this->hasOne(Genre::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }
}
