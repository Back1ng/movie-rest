<?php

namespace App\Tasks;

use Illuminate\Database\Eloquent\Builder;

class FindMovieByGenreTask
{
    public function run(Builder $builder, int $genreId): Builder
    {
        return $builder->where('genre_id', $genreId);
    }
}
