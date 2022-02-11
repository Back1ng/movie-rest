<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'genre_id'];

    public function genre()
    {
        return $this->hasOne(Genre::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public static function attachMoviesTo(Actor $model, array $movies)
    {
        if ($movies === []) {
            $model->movies()->detach();
        }

        foreach ($movies as $movie) {
            if (null === Movie::find($movie)) {
                throw new \Exception("Movie {$movie} not found.");
            }

            $model->movies()->detach($movie);

            $model->movies()->attach($movie);
        }

        return $model;
    }
}
