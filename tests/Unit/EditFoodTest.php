<?php

namespace Tests\Unit;

use App\Http\Controllers\FoodController;
use App\Http\Requests\Food\EditFoodRequest;
use App\Http\Services\FoodService;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditFoodTest extends TestCase
{
    use RefreshDatabase;

    private $foodController;
    private $foodService;

    public function setUp() : void {
        parent::setUp();
    }

    public function tearDown() : void {
        Mockery::close();
    }

    /** @test */
    public function mockery_edit_food_controller() {

        Event::fake();

        $request = new EditFoodRequest();
        $request->merge([
            'old_name'  => 'name',
            'new_name'  => 'new_name'
        ]);

        $this->foodService = Mockery::mock(FoodService::class);
        $this->app->instance(FoodService::class, $this->foodService);

        $this->foodService->shouldReceive('editFoodName')
            ->with($request['old_name'], $request['new_name'])
            ->once()
            ->andReturnTrue();

        $this->foodController = new FoodController($this->foodService);
        $response = $this->foodController->editFood($request);

        $this->assertTrue(is_object($response->getData()));
    }
}
