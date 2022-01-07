<?php

namespace Tests\Feature;

use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    public function test_invalid_source(): void
    {
        $response = $this->get('/transactions?source=html');

        $response->assertStatus(400);
    }

    public function test_db_source(): void
    {
        $response = $this->get('/transactions?source=db');

        $response->assertStatus(200);
        $this->assertNotEmpty($response->getContent());
    }

    public function test_csv_source(): void
    {
        $response = $this->get('/transactions?source=csv');

        $response->assertStatus(200);
        $this->assertNotEmpty($response->getContent());
    }
}
