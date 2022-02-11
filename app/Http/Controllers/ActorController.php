<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Movie;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Actor::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * Accepted post params:
     * [movies:int[]|null]
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $actor = Actor::firstOrCreate(
            $request->validate([
                'name' => 'string|required'
            ])
        );

        if ($request->has('movies')) {
            $movies = json_decode($request->post('movies'));

            try {
                Movie::attachMoviesTo($actor, $movies);
            } catch (Exception $e) {
                return response()->json($e->getMessage());
            }

            return response()->json($actor->movies);
        }

        return response()->json($actor);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(Actor::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $actor = Actor::find($id);
        $data = $request->validate([
            'name' => 'string|required'
        ]);
        $actor->name = $data['name'];
        $actor->save();

        return response()->json($actor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return response()->json(Actor::destroy($id));
    }
}
