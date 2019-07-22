<?php

namespace Tests\Unit;

use App\Http\Controllers\FoodController;
use App\Http\Requests\Food\AddFoodRequest;
use App\Http\Requests\Food\DeleteFoodRequest;
use App\Http\Requests\Food\EditFoodRequest;
use App\Http\Services\FoodService;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class FoodControllerTest extends TestCase
{
    use DatabaseMigrations;

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

    /** @test */
    public function mock_get_food_controller () {

        Event::fake();

        $request = new Request();

        $this->foodService = Mockery::mock(FoodService::class);
        $this->app->instance(FoodService::class, $this->foodService);
        $this->foodService->shouldReceive('getFood')
            ->once()
            ->andReturnTrue();

        $this->foodController = new FoodController($this->foodService);
        $response = $this->foodController->getFood($request);

        $this->assertTrue(is_string($response->getContent()));

        $response_body = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('response_code', $response_body);
        $this->assertArrayHasKey('data', $response_body);

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
        $response = $this->foodController->deleteFood($request);

        $this->assertTrue(is_string($response->getContent()));
    }
}
