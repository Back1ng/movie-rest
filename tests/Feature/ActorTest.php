<?php

use App\Models\Actor;
use App\Models\Movie;
use Database\Seeders\ActorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->beforeEach(function () {
    $this->seed(ActorSeeder::class);
});

test('actor index method return all records', function () {
    $response = decodeResponse(
        $this->get('/actors')
    );

    $this->assertEquals(count($response->data), 15);
});

test('actor created without movies', function() {
    $response = decodeResponse(
        $this->post('/actors', ['name' => "Good Name"])
    );

    $this->assertEquals($response->name, "Good Name");
});

test('store actor throw an error when adding non-existing movie', function () {
    $response = decodeResponse(
        $this->post('/actors', [
            'name' => "Good Name",
            'movies' => '[11111, 22222]',
        ])
    );

    $this->assertEquals(count((array)$response->errors), 2);
});

test('actor can be destroyed', function () {
    $actorCount = Actor::all()->count();

    $response = decodeResponse(
        $this->post('/actors', ['name' => "Good Name"])
    );

    $this->assertDatabaseCount('actors', $actorCount + 1);

    $this->delete('/actors/' . $response->id);

    $this->assertDatabaseCount('actors', $actorCount);
});

test('actor can be added with movie', function () {
    $responseGenre = decodeResponse(
        $this->post('/genres', ['name' => 'Ужасы'])
    );

    $movieResponse = decodeResponse(
        $this->post('movies', ['name' => 'Оно', 'genre_id' => $responseGenre->id])
    );

    $this->post('/actors', [
        'name' => "Билл Скарсгорд",
        'movies' => sprintf('[%s]', $movieResponse->id),
    ]);

    $response = decodeResponse(
        $this->post('/actors', [
            'name' => "Джейден Либерер",
            'movies' => sprintf('[%s]', $movieResponse->id),
        ])
    );

    $actors = Movie::find($movieResponse->id)->actors;

    $this->assertEquals(count($actors), 2);
    $this->assertEquals($actors[0]->name, "Билл Скарсгорд");
    $this->assertEquals($actors[1]->name, "Джейден Либерер");
});

test("actor can be updated", function() {
    $actorId = decodeResponse(
        $this->post('/actors', ['name' => "Билл Скарсгорд"])
    )->id;

    $response = decodeResponse(
        $this->put('/actors/' . $actorId, ['name' => 'Джейден Либерер'])
    );

    $this->assertEquals($response->name, 'Джейден Либерер');
    $this->assertEquals($response->id, $actorId);
});
