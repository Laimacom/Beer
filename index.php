<?php
require_once 'models.php';

$conn = connectDB();
$items = selectLatLon($conn);

$lat1 = 51.355468;
$lon1 = 11.100790;
echo 'Home is ' . $lat1 . " " . $lon1;
echo '<br>';
class Distance
{
    /**
     * Get distance between two coordinates
     *
     * @return float
     * @param  float $latitude1
     * @param  float $longitude1
     * @param  float $latitude2
     * @param  float $longitude2
     * @param  int     $decimals[optional] The amount of decimals
     * @param  string  $unit[optional]
     */
    public static function between(
        $latitude1,
        $longitude1,
        $latitude2,
        $longitude2,
        $decimals = 1,
        $unit = 'km'
    ) {
        // define calculation variables
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))
            + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)))
        ;
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        // unit is km
        if ($unit == 'km') {
            // redefine distance
            $distance = $distance * 1.609344;
        }
        // return with one decimal
        return round($distance, $decimals);
    }

    /**
     * Get closest location from all locations
     *
     * @return array   The item which is the closest + 'distance' to it.
     * @param  float $latitude1
     * @param  float $longitude1
     * @param  array $items = array(array('latitude' => 'x', 'longitude' => 'x'), array(xxx))
     * @param  int $decimals [optional] The amount of decimals
     * @param  string $unit [optional]
     */
    public static function getClosest(
        $latitude1,
        $longitude1,
        $items,
        $decimals = 1,
        $unit = 'km'
    ) {
        // init result
        $distances = array();
        // loop items
        foreach ($items as $key => $item) {
            // define second item
            $latitude2 = $item['latitude'];
            $longitude2 = $item['longitude'];
            // define distance
            $distance = self::between(
                $latitude1,
                $longitude1,
                $latitude2,
                $longitude2,
                10,
                $unit
            );
            // add distance
            $distances[$distance] = $key;
            // add rounded distance to array
            $items[$key]['distance'] = round($distance, $decimals);
        }
        // return the item with the closest distance, but not 0
        return $items[$distances[min(array_diff(array_map('floatval',array_keys($distances)), array(0)))]];
    }
}

//var_dump(Distance::getClosest($lat1, $lon1, $items, $decimals = 1, $unit = 'km'));
$firstBrewery = Distance::getClosest($lat1, $lon1, $items, $decimals = 1, $unit = 'km');
$id1 = $firstBrewery['brewery_id'];
$distance1 = $firstBrewery['distance'];
$lat1st = $firstBrewery['latitude'];
$lon1st = $firstBrewery['longitude'];

$breweries = selectFromBreweries($conn);

foreach ($breweries as $key => $brewery) {
    $name = $brewery ['name'];
    if ($id1 == $brewery['id']){
        echo 'First Brewery is ' . $name . '. Distance ' . $distance1 . 'km';
    }
}

$secondBrewery = Distance::getClosest($lat1st, $lon1st, $items, $decimals = 1, $unit = 'km');
echo '<br>';
//var_dump($secondBrewery);
$id2 = $secondBrewery['brewery_id'];
$distance2 = $secondBrewery['distance'];
$lat2st = $secondBrewery['latitude'];
$lon2st = $secondBrewery['longitude'];

foreach ($breweries as $key => $brewery) {
    $name = $brewery ['name'];
    if ($id2 == $brewery['id']){
        echo 'Second Brewery is ' . $name . '. Distance ' . $distance2 . 'km';
    }
}

$thirdBrewery = Distance::getClosest($lat2st, $lon2st, $items, $decimals = 1, $unit = 'km');
echo '<br>';
//var_dump($thirdBrewery);
$id3 = $thirdBrewery['brewery_id'];
$distance3 = $thirdBrewery['distance'];
$lat3st = $thirdBrewery['latitude'];
$lon3st = $thirdBrewery['longitude'];

foreach ($breweries as $key => $brewery) {
    $name = $brewery ['name'];
    if ($id3 == $brewery['id']){
        echo 'Third Brewery is ' . $name . '. Distance ' . $distance3 . 'km';
    }
}

$totalDistance = $distance1 + $distance2 + $distance3;
echo '<br>';
echo 'Total distance: ' . $totalDistance;





