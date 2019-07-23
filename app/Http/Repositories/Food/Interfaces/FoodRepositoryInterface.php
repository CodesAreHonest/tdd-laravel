<?php


namespace App\Http\Repositories\Food\Interfaces;


interface FoodRepositoryInterface
{
    public function getFoodWithNameOrPhoto($params);

    public function addFood($name, $photo);

    public function editFoodName ($old_name, $new_name);

    public function deleteFood ($id);
}