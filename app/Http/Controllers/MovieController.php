<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Accepted GET parameters:
     * genre - genre id (not required)
     * actor - actor id (not required)
     * sortBy - field (not required)
     * sortType - asc or desc (not required)
     *
     * By default return columns: id, genre_id, name, timestamps
     * If actor id is included, return next columns: id, genre_id, name, actor_name, timestamps
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $movies = DB::table('movies');

        if ($request->has('genre')) {
            $movies->where('genre_id', '=', $request->get('genre'));
        }

        if ($request->has('actor')) {
            $movies->join('actor_movie', 'actor_id', '=', 'movies.id');
            $movies->where('actor_movie.actor_id', '=', $request->get('actor'));
            $movies->leftJoin('actors', 'actors.id', '=', 'actor_movie.actor_id');

            $movies->select(
                'movies.id',
                'movies.genre_id',
                'movies.name',
                'actors.name as actor_name',
                'movies.created_at',
                'movies.updated_at'
            );
        }

        if ($request->has('sortBy')) {
            if ($request->get('sortBy') === 'name') {
                if ($request->has('sortType')) {
                    match ($request->get('sortType')) {
                        'asc' => $movies->orderBy('movies.name'),
                        'desc' => $movies->orderByDesc('movies.name'),
                    };
                } else {
                    $movies->orderBy('movies.name');
                }
            }
        }

        return response()->json($movies->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        return response()->json(
            Movie::create($request->validate([
                'name' => 'string|required',
                'genre_id' => 'numeric|required',
            ]))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(Movie::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);

        $data = $request->validate([
            'genre_id' => 'numeric',
            'name' => 'string',
        ]);

        if (! empty($data['name'])) {
            $movie->name = $data['name'];
        }

        if (! empty($data['genre_id'])) {
            $movie->genre_id = $data['genre_id'];
        }

        $movie->save();

        return response()->json($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return response()->json(Movie::destroy($id));
    }
}
