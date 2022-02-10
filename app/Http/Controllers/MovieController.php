<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Repositories\MovieRepository;
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
        $movies = new MovieRepository();

        if ($request->has('genre')) {
            $movies->whereGenre($request->get('genre'));
        }

        if ($request->has('actor')) {
            $movies->whereActor($request->get('actor'));
        }

        if ($request->has('sortBy')) {
            if ($request->has('sortType')) {
                $movies->withSort($request->get('sortBy'), $request->get('sortType'));
            } else {
                $movies->withSort($request->get('sortBy'));
            }
        }

        return response()->json($movies->getResult());
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
