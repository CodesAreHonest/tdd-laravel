<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'food';

    public function addFood ($name, $photo) {

        $params = [
            'name'  => $name,
            'photo' => $photo
        ];

        $outcome = self::insert($params);

        return $outcome;
    }

    public function editFoodName ($old_name, $new_name) {

        $params = [
            'name'  => $new_name
        ];

        $outcome = self::where('name', $old_name)
            ->update($params);

        return $outcome;

    }

    public function getFood ($params) {

        $query = self::query();

        if (array_key_exists('name', $params)) {
            $query->where('name', $params['name']);
        }

        if (array_key_exists('photo', $params)) {
            $query->where('photo', $params['photo']);
        }

        return $query->get();
    }

    public function deleteFood ($id) {

        $outcomes = self::whereId($id)->delete();

        return $outcomes;
    }


}
