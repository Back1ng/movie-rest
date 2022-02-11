<?php

use Database\Seeders\ActorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('actor index method return all records', function () {
    $this->seed(ActorSeeder::class);

    $response = decodeResponse(
        $this->get('/actors')
    );

    $this->assertEquals(count($response), 10);
});

test('test actor created without movies', function() {
    $response = decodeResponse(
        $this->post('/actors', ['name' => "Good Name"])
    );

    $this->assertEquals($response->name, "Good Name");
    $this->assertEquals($response->id, 11);
});
