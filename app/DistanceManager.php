<?php

namespace App;

class DistanceManager
{
    // Средний радиус земного шара в километрах
    const EARTH_RADIUS = 6371;

    public function getDistanceToAll($initialPlace, $placesToMeasure)
    {
        $result = [];

        foreach ($placesToMeasure as $placeToMeasure) {
            $result[$placeToMeasure['address']] = $this->measureDistanceBetweenTwo($initialPlace, $placeToMeasure);
        }

        return collect($result);
    }

    public function measureDistanceBetweenTwo($placeOne, $placeTwo): int
    {
        $d = acos(sin($placeOne['lat']) * sin($placeTwo['lat']) + cos($placeOne['lat']) * cos($placeTwo['lat']) * cos($placeOne['lng'] - $placeTwo['lng']));

        // Дистанция в километрах
        return round($distance = $d * self::EARTH_RADIUS);
    }
}
