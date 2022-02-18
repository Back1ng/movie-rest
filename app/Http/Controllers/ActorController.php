<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\StoreActorRequest;
use App\Http\Requests\Api\UpdateActorRequest;
use App\Models\Actor;
use Illuminate\Http\JsonResponse;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Actor::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * Accepted post params:
     * [movies:int[]|null]
     *
     * @param StoreActorRequest $request
     * @return JsonResponse
     */
    public function store(StoreActorRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $actor = Actor::create($validated);

        if ($request->has('movies')) {
            $actor->movies()->sync($validated['movies']);
        }

        return response()->json($actor);
    }

    /**
     * Display the specified resource.
     *
     * @param Actor $actor
     * @return JsonResponse
     */
    public function show(Actor $actor): JsonResponse
    {
        return response()->json($actor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateActorRequest $request
     * @param Actor $actor
     * @return JsonResponse
     */
    public function update(UpdateActorRequest $request, Actor $actor): JsonResponse
    {
        $actor->update([
            'name' => $request->validated('name')
        ]);

        return response()->json($actor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Actor $actor
     * @return JsonResponse
     */
    public function destroy(Actor $actor): JsonResponse
    {
        return response()->json($actor->delete());
    }
}
