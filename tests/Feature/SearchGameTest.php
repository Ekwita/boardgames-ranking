<?php

test('search game by query', function () {
    $response = $this->get('/api/search?search=nemesis');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        '*' => [
            'id',
            'name',
            'year',
        ],
    ]);

    dd($response);
});
