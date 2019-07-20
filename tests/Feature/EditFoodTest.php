<?php

namespace Tests\Feature;

use App\Http\Requests\Food\AddFoodRequest;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditFoodTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void {
        parent::setUp();

        $this->add_food_for_testing();
    }

    public function tearDown(): void {
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
    public function return_created() {

        $data = [
            'old_name'  => 'name',
            'new_name'  => 'new_name'
        ];

        $response = $this->put(route('edit.food'), $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'response_code', 'response_msg'
        ]);

        $this->assertDatabaseHas('food', [
            'name'  => 'new_name',
            'photo' => 'photo'
        ]);
    }

    /** @test */
    public function return_unprocessable_entity() {

        $data = [
            'new_name'  => 'new_name'
        ];

        $response = $this->put(route('edit.food'), $data);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'status', 'type',
            'message' => [
                'old_name', 'new_name'
            ]
        ]);
        $response->assertJson([
            'status'    => 422,
            'type'      => 'ValidationException',
            'message'   => [
                'old_name'  => [
                    'The old name field is required.'
                ],
                'new_name'  => [
                    'The new name and old name must be different.'
                ]
            ]
        ]);
    }

    /** @test */
    public function return_records_not_found () {

        $this->add_food_for_testing();

        $data = [
            'old_name'  => 'names',
            'new_name'  => 'new_name'
        ];

        $response = $this->put(route('edit.food'), $data);
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'response_code', 'response_msg'
        ]);

        $response->assertJson([
            'response_code'    => 404,
            'response_msg'     => 'Records not found'
        ]);

    }
}
