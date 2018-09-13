<?php

namespace App;

class DistanceManager 
{
    // Средний радиус земного шара в километрах
    const EARTH_RADIUS = 6371;

    public function getDistanceToAll($initialPlace, array $placesToMeasure)
    {
        $result = [];

        foreach($placesToMeasure as $placeToMeasure){
            $result[$placeToMeasure['address']] = $this->measureDistanceBetweenTwo($initialPlace, $placeToMeasure);
        }

        return $result = $this->getOnlyWithDistance($result);
    }

    public function measureDistanceBetweenTwo($placeOne, $placeTwo) : int
    {
        $d = acos(sin($placeOne['lat'])*sin($placeTwo['lat'])+cos($placeOne['lat'])*cos($placeTwo['lat'])*cos($placeOne['lng']-$placeTwo['lng']));
        
        // Дистанция в километрах
        return round($distance = $d * self::EARTH_RADIUS);
    }

    public function getOnlyWithDistance(array $array)
    {
        $filteredArray = collect($array)->filter(function($value, $key){
            return $value !== 0;
        });

        return $filteredArray;
    }
}
