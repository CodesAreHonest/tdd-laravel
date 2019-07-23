<?php


namespace App\Http\Repositories\Food;

use App\Http\Repositories\Food\Interfaces\FoodRepositoryInterface;
use App\Model\Food;

class FoodRepository implements FoodRepositoryInterface
{
    private $food;

    public function __construct(Food $food) {
        $this->food = $food;
    }

    public function getFoodWithNameOrPhoto ($params) {

        $query = $this->food->query();

        if (array_key_exists('name', $params)) {
            $query->where('name', $params['name']);
        }

        if (array_key_exists('photo', $params)) {
            $query->where('photo', $params['photo']);
        }

        return $query->get();
    }

    public function addFood ($name, $photo) {

        $params = [
            'name'  => $name,
            'photo' => $photo
        ];

        $outcome = Food::insert($params);

        return $outcome;
    }

    public function editFoodName ($old_name, $new_name) {

        $params = [
            'name'  => $new_name
        ];

        $outcome = Food::where('name', $old_name)
            ->update($params);

        return $outcome;

    }

    public function deleteFood ($id) {

        $outcomes = Food::whereId($id)->delete();

        return $outcomes;
    }


}