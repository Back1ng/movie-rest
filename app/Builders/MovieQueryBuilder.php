<?php

namespace App\Builders;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class MovieQueryBuilder
{
    private Builder $query;

    private array $data;

    public function __construct()
    {
        $this->query = Movie::query();
    }

    /**
     * @param mixed $validated
     * @return Builder
     */
    public function build(array $validated): Builder
    {
        $this->data = $validated;

        $this->whereGenre()
            ->whereActor()
            ->addSort();

        return $this->query;
    }

    /**
     * @return MovieQueryBuilder
     */
    private function whereGenre(): self
    {
        if (Arr::has($this->data, 'genre_id')) {
            $this->query->where('genre_id', $this->data['genre_id']);
        }

        return $this;
    }

    /**
     * @return MovieQueryBuilder
     */
    private function whereActor(): self
    {
        if (Arr::has($this->data, 'actor_id')) {
            $this->query->whereRelation('actors', 'actor_id', $this->data['actor_id']);
        }

        return $this;
    }

    /**
     * @return MovieQueryBuilder
     */
    private function addSort(): self
    {
        if (Arr::has($this->data, 'sortBy')) {
            if (Arr::has($this->data, 'sortType')) {
                match ($this->data['sortType']) {
                    'desc' => $this->query->latest($this->data['sortBy']),
                    'default' => $this->query->oldest($this->data['sortBy']),
                };
            } else {
                $this->query->oldest($this->data['sortBy']);
            }
        }

        return $this;
    }
}
