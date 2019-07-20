<?php

namespace Tests\Unit;

use App\Http\Controllers\FoodController;
use App\Http\Requests\Food\AddFoodRequest;
use App\Http\Services\FoodService;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddFoodTest extends TestCase
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
    public function mockery_mock_add_food_controller() {

        $request = new AddFoodRequest;

        $request->merge([
            'name'  => 'Pizza',
            'photo' => 'pizza.jpg'
        ]);

        $this->foodService = Mockery::mock(FoodService::class);
        $this->app->instance(FoodService::class, $this->foodService);
        $this->foodService->shouldReceive('addNameAndPhoto')
            ->with($request['name'], $request['photo'])
            ->andReturnTrue();

        $this->foodController = new FoodController($this->foodService);

        $response = $this->foodController->addFood($request);

        $this->assertEquals($response->getStatusCode(), 201);
        $this->assertTrue(is_object($response->getData()));

    }

    /** @test */
    public function phpunit_mock_add_food_controller() {

        Event::fake();

        $name = 'name';
        $photo = 'photo';

        $foodService = $this->createMock(FoodService::class);
        $foodService->expects($this->once())
            ->method('addNameAndPhoto')
            ->with('name', 'photo')
            ->willReturn(true);

        $this->assertTrue($foodService->addNameAndPhoto($name, $photo));
    }
}
