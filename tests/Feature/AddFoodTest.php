<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

class AddFoodTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void {
        parent::setUp();
    }

    public function tearDown(): void {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function functional_test_add_food_return_created() {

        Event::fake();

        $data = [
            'name'  => 'name',
            'photo' => 'photo'
        ];

        $response = $this->post(route('add.food'), $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'response_code', 'response_msg'
        ]);
        $response->assertJson([
            'response_code' => 201,
            'response_msg'  => 'success'
        ]);

        $this->assertDatabaseHas('food', [
            'name'  => 'name',
            'photo' => 'photo',
        ]);
    }
}

