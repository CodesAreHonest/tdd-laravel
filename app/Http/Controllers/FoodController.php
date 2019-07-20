<?php

namespace App\Http\Controllers;

use App\Http\Requests\Food\AddFoodRequest;
use App\Http\Requests\Food\EditFoodRequest;
use App\Http\Services\FoodService;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    private $foodService;

    public function __construct(FoodService $foodService) {
        $this->foodService = $foodService;
    }

    public function addFood (AddFoodRequest $request) {

        $name = $request['name'];
        $photo = $request['photo'];

        $outcomes = $this->foodService->addNameAndPhoto($name, $photo);

        if (!$outcomes) {
            return response()->json([
                'response_code' => 500,
                'response_msg'  => 'internal server error'
            ], 500);
        }

        return response()->json([
            'response_code' => 201,
            'response_msg'  => 'success'
        ], 201);
    }

    public function editFood(EditFoodRequest $request) {

        $old_name = $request['old_name'];
        $new_name = $request['new_name'];

        $outcomes = $this->foodService->editFoodName($old_name, $new_name);

        if (!$outcomes) {
            return response()->json ([
                'response_code' => 404,
                'response_msg'  => 'Records not found'
            ], 404);
        }

        return response()->json ([
            'response_code' => 201,
            'response_msg'  => 'Created'
        ], 201);


    }

    public function getFood (Request $request) {

        $params = [];

        if ($request->has('name')) {
            $params['name'] = $request['name'];
        }

        if ($request->has('photo')) {
            $params['photo'] = $request['photo'];
        }

        $data = $this->foodService->getFood($params);

        return response()->json ([
            'response_code' => 200,
            'data'          => $data
        ], 200);

    }

    public function deleteFood (Request $request) {

        $id = $request['id'];

        $outcome = $this->foodService->deleteFood($id);

        if (!$outcome) {
            return response()->json ([
                'response_code' => 404,
                'response_msg'  => 'Records not found'
            ], 500);
        }

        return response()->json ([
            'response_code' => 200,
            'response_msg'  => 'Success'
        ], 200);

    }
}
