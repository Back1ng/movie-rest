<?php

use App\Models\Movie;
use Database\Seeders\ActorSeeder;

uses()->beforeEach(function () {
    $this->seed(ActorSeeder::class);
});

test('actor index method return all records', function () {
    $response = decodeResponse(
        $this->get('/actors')
    );

    $this->assertEquals(count($response), 10);
});

test('actor created without movies', function() {
    $response = decodeResponse(
        $this->post('/actors', ['name' => "Good Name"])
    );

    $this->assertEquals($response->name, "Good Name");
    $this->assertEquals($response->id, 21);
});

it('throw error when trying add to non-existent movie', function () {
    $response = decodeResponse(
        $this->post('/actors', [
            'name' => "Good Name",
            'movies' => '[111, 222]',
        ])
    );

    $this->assertEquals($response, 'Movie 111 not found.');
});

it('actor can be destroyed', function () {
    $response = decodeResponse(
        $this->post('/actors', ['name' => "Good Name"])
    );

    $this->assertDatabaseCount('actors', 11);

    $this->delete('/actors/' . $response->id);

    $this->assertDatabaseCount('actors', 10);
});

test('actor can be added with movie', function () {
    $this->post('/genres', ['name' => 'Ужасы']);
    $this->post('movies', ['name' => 'Оно', 'genre_id' => 1]);

    $response = decodeResponse(
        $this->post('/actors', [
            'name' => "Билл Скарсгорд",
            'movies' => '[1]',
        ])
    );

    $response = decodeResponse(
        $this->post('/actors', [
            'name' => "Джейден Либерер",
            'movies' => '[1]',
        ])
    );

    $actors = Movie::find($response[0]->id)->actors;

    $this->assertEquals(count($actors), 2);
    $this->assertEquals($actors[0]->name, "Билл Скарсгорд");
    $this->assertEquals($actors[1]->name, "Джейден Либерер");
});
