<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FoodController;
use App\Http\Requests\FoodRequest;
use App\Http\Services\FoodService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery;

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
    }

    /**
     * @test
     */
    public function mockery_mock_add_food_controller() {

        $request = new FoodRequest;

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

