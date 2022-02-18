<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\IndexMovieRequest;
use App\Http\Requests\Api\StoreMovieRequest;
use App\Http\Requests\Api\UpdateMovieRequest;
use App\Models\Movie;
use App\Builders\MovieQueryBuilder;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Accepted GET parameters:
     * genre_id - genre id (not required)
     * actor_id - actor id (not required)
     * sortBy - field (not required)
     * sortType - asc or desc (not required)
     *
     * By default, return columns: id, genre_id, name, timestamps
     * If actor id is included, return next columns: id, genre_id, name, actor_name, timestamps
     *
     * @param IndexMovieRequest $request
     * @param MovieQueryBuilder $movieQueryBuilder
     * @return JsonResponse
     */
    public function index(IndexMovieRequest $request, MovieQueryBuilder $movieQueryBuilder): JsonResponse
    {
        $validated = $request->validated();

        $movie = $movieQueryBuilder->build($validated);

        return response()->json($movie->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMovieRequest $request
     * @return JsonResponse
     */
    public function store(StoreMovieRequest $request): JsonResponse
    {
        return response()->json(Movie::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param Movie $movie
     * @return JsonResponse
     */
    public function show(Movie $movie): JsonResponse
    {
        return response()->json($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMovieRequest $request
     * @param Movie $movie
     * @return JsonResponse
     */
    public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
    {
        $data = $request->validated();

        $movie->update([
            'name' => $data['name'],
            'genre_id' => $data['genre_id']
        ]);

        return response()->json($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie
     * @return JsonResponse
     */
    public function destroy(Movie $movie): JsonResponse
    {
        return response()->json($movie->delete());
    }
}
