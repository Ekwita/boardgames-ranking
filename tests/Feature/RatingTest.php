<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingTest
{
    use RefreshDatabase; // Jeśli chcesz zresetować bazę danych po każdym teście


    /**
     * Testuje metodę vote w RatingController.
     *
     * @return void
     */
    public function test_vote()
    {
        // Przygotowanie danych do wysłania
        $data = [
            'id' => 1,
            'name' => 'Example Game',
        ];

        // Wysyłamy żądanie POST do /vote
        $response = $this->postJson('/api/vote', $data);

        // Sprawdzamy, czy odpowiedź jest poprawna (status 200 OK)
        $response->assertStatus(200);

        // Możesz także sprawdzić, czy odpowiedź zawiera oczekiwane dane
        // np. sprawdzenie zawartości odpowiedzi
        $response->assertJson($data);
    }
}
