<?php

namespace App\Tasks;

use Illuminate\Database\Eloquent\Builder;

class FindMovieByActorTask
{
    public function run(Builder $builder, int $actorId): Builder
    {
        return $builder->whereRelation('actors', 'actor_id', $actorId);
    }
}
