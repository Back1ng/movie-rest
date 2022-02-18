<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\StoreGenreRequest;
use App\Http\Requests\Api\UpdateGenreRequest;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Genre::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGenreRequest $request
     * @return JsonResponse
     */
    public function store(StoreGenreRequest $request): JsonResponse
    {
        return response()->json(Genre::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param Genre $genre
     * @return JsonResponse
     */
    public function show(Genre $genre): JsonResponse
    {
        return response()->json($genre);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Genre $genre
     * @return JsonResponse
     */
    public function update(UpdateGenreRequest $request, Genre $genre): JsonResponse
    {
        $genre->update([
            'name' => $request->validated('name')
        ]);

        return response()->json($genre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Genre $genre
     * @return JsonResponse
     */
    public function destroy(Genre $genre): JsonResponse
    {
        return response()->json($genre->delete());
    }
}
