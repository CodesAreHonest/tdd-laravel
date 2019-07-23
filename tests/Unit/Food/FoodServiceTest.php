<?php

namespace Tests\Unit\Food;

use App\Http\Repositories\Food\Interfaces\FoodRepositoryInterface;
use App\Http\Services\FoodService;
use App\Model\Food;
use Tests\TestCase;
use Mockery;

class FoodServiceTest extends TestCase
{
    private $foodService;
    private $foodRepo;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /** @test */
    public function mock_add_name_and_photo () {

        $name = 'string';
        $photo = 'string';

        $this->foodRepo = Mockery::mock(FoodRepositoryInterface::class);
        $this->app->instance(FoodRepositoryInterface::class, $this->foodRepo);

        $this->foodRepo->shouldReceive('addFood')
            ->with($name, $photo)
            ->once()
            ->andReturnTrue();

        $this->foodService = new FoodService($this->foodRepo);
        $response = $this->foodService->addNameAndPhoto($name, $photo);

        $this->assertTrue(is_bool($response));
        $this->assertEquals($response, true);

    }

    /** @test */
    public function mock_edit_food_name () {

        $this->mock_add_name_and_photo();

        $old_name = 'old_name';
        $new_name = 'new_name';

        $this->foodRepo = Mockery::mock(FoodRepositoryInterface::class);
        $this->app->instance(FoodRepositoryInterface::class, $this->foodRepo);

        $this->foodRepo->shouldReceive('editFoodName')
            ->with($old_name, $new_name)
            ->once()
            ->andReturnTrue();

        $this->foodService = new FoodService($this->foodRepo);
        $response = $this->foodService->editFoodName($old_name, $new_name);

        $this->assertTrue(is_bool($response));
        $this->assertEquals($response, true);

    }

    /** @test */
    public function mock_get_food_name () {

        $this->mock_add_name_and_photo();

        $params = [];

        $this->foodRepo = Mockery::mock(FoodRepositoryInterface::class);
        $this->app->instance(FoodRepositoryInterface::class, $this->foodRepo);

        $food = new Food();
        $data = $food-> get();

        $this->foodRepo->shouldReceive('getFoodWithNameOrPhoto')
            ->with($params)
            ->once()
            ->andReturn($data);

        $this->foodService = new FoodService($this->foodRepo);
        $response = $this->foodService->getFood($params);

        $this->assertTrue(is_object($response));

    }

    /** @test */
    public function mock_delete_food() {

        $this->mock_add_name_and_photo();

        $id = 1;

        $this->foodRepo = Mockery::mock(FoodRepositoryInterface::class);
        $this->app->instance(FoodRepositoryInterface::class, $this->foodRepo);

        $this->foodRepo->shouldReceive('deleteFood')
            ->with($id)
            ->once()
            ->andReturnTrue();

        $this->foodService = new FoodService($this->foodRepo);
        $response = $this->foodService->deleteFood($id);

        $this->assertTrue(is_bool($response));
        $this->assertEquals($response, true);

    }


}
