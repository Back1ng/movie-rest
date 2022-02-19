<?php

namespace App\Actions;

use App\Http\Requests\Api\IndexMovieRequest;
use App\Models\Movie;
use App\Tasks\FindMovieByActorTask;
use App\Tasks\FindMovieByGenreTask;
use App\Tasks\FindMovieWithSortTask;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class FindMovieByCriteriaAction
{
    public function run(IndexMovieRequest $request): LengthAwarePaginator
    {
        $validated = $request->validated();

        $movie = Movie::query();

        if (Arr::has($validated, 'genre_id')) {
            $movie = (new FindMovieByGenreTask())->run($movie, $validated['genre_id']);
        }

        if (Arr::has($validated, 'actor_id')) {
            $movie = (new FindMovieByActorTask())->run($movie, $validated['actor_id']);
        }

        if (Arr::hasAny($validated, ['sortBy', 'sortType'])) {
            $movie = (new FindMovieWithSortTask())->run(
                $movie,
                Arr::get($validated, 'sortBy'),
                Arr::get($validated, 'sortType')
            );
        }

        return $movie->paginate();
    }
}
