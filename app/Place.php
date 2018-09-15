<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public $timestamps = false;

    protected $fillable = ["address", "lat", "lng"];

    public static function getAllExcept(Place $place)
    {
        $otherPlaces = self::all()->filter(function ($value, $key) use ($place) {
            return $value->id !== $place->id;
        });

        return $otherPlaces;
    }
}
