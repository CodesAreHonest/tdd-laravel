<?php

namespace Tests\Feature;

use App\Http\Requests\Food\AddFoodRequest;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteFoodTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->add_food_for_testing();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    private function add_food_for_testing() {

        Event::fake();

        $request = new AddFoodRequest();
        $request->merge([
            'name'  => 'name',
            'photo' => 'photo'
        ]);

        $controller = $this->app->make('App\Http\Controllers\FoodController');
        $controller->addFood($request);

    }

    /** @test */
    public function return_success() {

        Event::fake();

        $data = [
            'id'    => 2
        ];

        $response = $this->delete(route('delete.food'), $data);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'response_code', 'response_msg'
        ]);
        $response->assertJson([
            'response_code' => 200,
            'response_msg'  => 'Success'
        ]);

        $this->assertDatabaseMissing('food', [
            'name'  => 'name',
            'photo' => 'photo'
        ]);

    }

    /** @test */
    public function return_unprocessable_entity() {

        Event::fake();

        $data = [];

        $response = $this->delete(route('delete.food'), $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'status', 'type', 'message' => [
                'id'
            ]
        ]);
        $response->assertJson([
            'status'    => 422,
            'type'      => 'ValidationException',
            'message'   => [
                'id'    => [
                    'The id field is required.'
                ]
            ]
        ]);

        $this->assertDatabaseHas('food', [
            'name'  => 'name',
            'photo' => 'photo'
        ]);
    }

    /** @test */
    public function return_internal_server_error() {

        Event::fake();

        $data = [
            'id'    => 3
        ];

        $response = $this->delete(route('delete.food'), $data);
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'response_code', 'response_msg'
        ]);
        $response->assertJson([
            'response_code' => 404,
            'response_msg'  => 'Records not found'
        ]);

        $this->assertDatabaseHas('food', [
            'name'  => 'name',
            'photo' => 'photo'
        ]);
    }


}
