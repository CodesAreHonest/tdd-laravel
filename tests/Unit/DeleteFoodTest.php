<?php

namespace Tests\Unit;

use App\Http\Controllers\FoodController;
use App\Http\Requests\Food\DeleteFoodRequest;
use App\Http\Services\FoodService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class DeleteFoodTest extends TestCase
{
    use RefreshDatabase;

    private $foodController;
    private $foodService;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /** @test */
    public function mock_delete_food_controller() {

        $request = new DeleteFoodRequest();
        $request->merge([
            'id'    => 1
        ]);

        $this->foodService = Mockery::mock(FoodService::class);
        $this->app->instance(FoodService::class, $this->foodService);
        $this->foodService->shouldReceive('deleteFood')
            ->with($request['id'])
            ->once()
            ->andReturnTrue();

        $this->foodController = new FoodController($this->foodService);
        $this->foodController->deleteFood($request);
    }
}
