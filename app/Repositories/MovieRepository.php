<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class MovieRepository
{
    private $query;

    private string $tableName = 'movies';

    public function __construct()
    {
        $this->query = DB::table($this->getTableName());
    }

    public function whereGenre($id)
    {
        $this->query->where('genre_id', '=', $id);
    }

    public function whereActor($id)
    {
        $this->query->join('actor_movie', 'movie_id', '=', 'movies.id');
        $this->query->where('actor_movie.actor_id', '=', $id);
        $this->query->leftJoin('actors', 'actors.id', '=', 'actor_movie.actor_id');

        $this->query->select(
            'movies.id',
            'movies.genre_id',
            'movies.name',
            'actors.name as actor_name',
            'movies.created_at',
            'movies.updated_at'
        );
    }

    public function withSort(string $field, string $type = 'asc') {
        if ($field === 'name') {
            match ($type) {
                'asc' => $this->query->orderBy('movies.name'),
                'desc' => $this->query->orderByDesc('movies.name'),
            };
        }
    }

    public function getResult()
    {
        return $this->query->get();
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}
