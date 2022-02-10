<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Actor::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $actor = Actor::firstOrCreate(
            $request->validate([
                'name' => 'string|required'
            ])
        );

        if ($request->has('movies')) {
            $movies = json_decode($request->post('movies'));

            if (is_array($movies)) {
                if ($movies === []) {
                    $actor->movies()->detach();
                } else {
                    foreach ($movies as $movie) {
                        $actor->movies()->detach($movie);

                        $actor->movies()->attach($movie);
                    }
                }
            }

            return response()->json($actor->movies);
        }

        return response()->json($actor);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Actor::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return response()->json(Actor::destroy($id));
    }
}
