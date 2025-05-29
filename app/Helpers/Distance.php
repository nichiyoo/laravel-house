<?php

namespace App\Helpers;

class Distance
{
  /**
   * The radius of the earth in kilometers.
   */
  const EARTH_RADIUS = 6371;

  /**
   * Function to calculate the distance between two points on the earth.
   * 
   * @param  float  $lat1
   * @param  float  $lon1
   * @param  float  $lat2
   * @param  float  $lon2
   * @param  float  $radius  The radius of the earth in kilometers.
   * @return float
   */
  static function haversine($lat1, $lon1, $lat2, $lon2, $radius = self::EARTH_RADIUS)
  {
    $latFrom = deg2rad($lat1);
    $lonFrom = deg2rad($lon1);
    $latTo = deg2rad($lat2);
    $lonTo = deg2rad($lon2);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $sinLat = sin($latDelta / 2);
    $sinLon = sin($lonDelta / 2);
    $sinLatSq = pow($sinLat, 2);
    $sinLonSq = pow($sinLon, 2);

    $a = $sinLatSq + cos($latFrom) * cos($latTo) * $sinLonSq;
    $angle = 2 * asin(sqrt($a));

    return $angle * $radius;
  }
}
