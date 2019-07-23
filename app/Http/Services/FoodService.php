<?php


namespace App\Http\Services;

use App\Http\Repositories\Food\Interfaces\FoodRepositoryInterface;
use App\Model\Food;
use Exception;


class FoodService
{
    private $foodRepository;

    /**
     * FoodService constructor.
     * @param FoodRepositoryInterface $foodRepository
     */
    public function __construct(FoodRepositoryInterface $foodRepository) {
        $this->foodRepository = $foodRepository;
    }

    /**
     * Add Name and Photo
     *
     * @param   string      $name
     * @param   string      $photo
     * @return  boolean     $outcome
     */
    public function addNameAndPhoto ($name, $photo) {

        try {
             $outcome = $this->foodRepository->addFood($name, $photo);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }

        return $outcome;
    }


    public function editFoodName ($old_name, $new_name) {

        try {
            $outcome = $this->foodRepository->editFoodName($old_name, $new_name);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }

        return $outcome;

    }

    public function getFood ($params) {

        try {
            $outcome = $this->foodRepository->getFoodWithNameOrPhoto($params);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $outcome;
    }

    public function deleteFood ($id) {

        try {
            $outcome = $this->foodRepository->deleteFood($id);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $outcome;
    }

}