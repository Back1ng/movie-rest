<?php

namespace App\Tasks;

use Illuminate\Database\Eloquent\Builder;

class FindMovieWithSortTask
{
    public function run(Builder $builder, $field = 'id', $type = 'asc')
    {
        match ($type) {
            'desc' => $builder->latest($field ?? 'id'),
            default => $builder->oldest($field ?? 'id')
        };

        return $builder;
    }
}
