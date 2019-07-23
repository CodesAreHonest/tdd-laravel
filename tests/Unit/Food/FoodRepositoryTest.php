<?php

namespace Tests\Unit\Food;

use App\Http\Repositories\Food\FoodRepository;
use App\Model\Food;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class FoodRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $foodRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->foodRepository = $this->app->make(FoodRepository::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /** @test */
    public function mock_get_food_with_name_or_photo() {

        $params = [
            'name'  => 'name',
            'photo' => 'photo'
        ];

        $query = Food::where('name', $params['name'])
            ->where('photo', $params['photo'])
            ->get();

        $response = $this->foodRepository->getFoodWithNameOrPhoto($params);

        $this->assertEquals($response, $query);
    }

    /** @test */
    public function mock_add_food() {

        $params = [
            'name'  => 'name',
            'photo' => 'photo'
        ];

        $query = Food::insert($params);

        $response = $this->foodRepository->addFood('name', 'photo');

        $this->assertEquals($response, $query);
    }

    /** @test */
    public function mock_edit_food_name () {

        $params = [
            'name'  => 'new_name'
        ];

        $query = Food::where('name', $params)
            ->update($params);

        $response = $this->foodRepository->editFoodName('name', 'new_name');

        $this->assertEquals($response, $query);
    }

    /** @test */
    public function mock_delete_food () {

        $id = 1;

        $query = Food::whereId($id)->delete();

        $response = $this->foodRepository->deleteFood($id);

        $this->assertEquals($response, $query);
    }

}
