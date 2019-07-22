<?php


namespace App\Http\Services;

use App\Model\Food;
use Exception;


class FoodService
{
    private $food;

    /**
     * FoodService constructor.
     * @param Food $food
     */
    public function __construct(Food $food) {
        $this->food = $food;
    }

    /**
     * @param   string      $name
     * @param   string      $photo
     * @return  boolean     $outcome
     */
    public function addNameAndPhoto ($name, $photo) {

        try {
             $outcome = $this->food->addFood($name, $photo);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }

        return $outcome;
    }


    public function editFoodName ($old_name, $new_name) {

        try {
            $outcome = $this->food->editFoodName($old_name, $new_name);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $outcome;

    }

    public function getFood ($params) {

        try {
            $outcome = $this->food->getFood($params);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $outcome;
    }

    public function deleteFood ($id) {

        try {
            $outcome = $this->food->deleteFood($id);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $outcome;
    }

}