<?php

use Database\Seeders\ActorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    $response = decodeResponse(
        $this->delete('/actors/' . $response->id)
    );

    $this->assertDatabaseCount('actors', 10);
});
