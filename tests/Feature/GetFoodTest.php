<?php

namespace Tests\Feature;

use App\Http\Requests\Food\AddFoodRequest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetFoodTest extends TestCase
{
    use DatabaseMigrations;

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

        $response = $this->get(route('get.food'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'response_code', 'data' => [
                '*' => ['id', 'name', 'photo', 'created_at', 'updated_at']
            ]
        ]);
    }
}
