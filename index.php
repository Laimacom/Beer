<?php
namespace Beer;
require_once 'models.php';
require_once 'Distance.php';
require_once 'views.php';

form();
if (isset($_POST['lat1'])) {
    $conn = connectDB();
    $items = selectLatLon($conn);

    $lat1 = $_POST['lat1'];
    $lon1 = $_POST['lon1'];
    echo 'Home is ' . $lat1 . " " . $lon1;
    echo '<br>';

    //var_dump(Distance::getClosest($lat1, $lon1, $items, $decimals = 1, $unit = 'km'));
    $firstBrewery = Distance::getClosest($lat1, $lon1, $items, $decimals = 1, $unit = 'km');
    $id1 = $firstBrewery['brewery_id'];
    $distance1 = $firstBrewery['distance'];
    $lat1st = $firstBrewery['latitude'];
    $lon1st = $firstBrewery['longitude'];

    $breweries = selectFromBreweries($conn);

    breweries($breweries, $id1, $number = 'First', $distance1);

    beersFound($id1, $conn);

    $secondBrewery = Distance::getClosest($lat1st, $lon1st, $items, $decimals = 1, $unit = 'km');
    echo '<br>';
    //var_dump($secondBrewery);
    $id2 = $secondBrewery['brewery_id'];
    $distance2 = $secondBrewery['distance'];
    $lat2st = $secondBrewery['latitude'];
    $lon2st = $secondBrewery['longitude'];

    breweries($breweries, $id2, $number = 'Second', $distance2);

    beersFound($id2, $conn);

    $thirdBrewery = Distance::getClosest($lat2st, $lon2st, $items, $decimals = 1, $unit = 'km');
    echo '<br>';
    //var_dump($thirdBrewery);
    $id3 = $thirdBrewery['brewery_id'];
    $distance3 = $thirdBrewery['distance'];
    $lat3st = $thirdBrewery['latitude'];
    $lon3st = $thirdBrewery['longitude'];

    breweries($breweries, $id3, $number = 'Third', $distance3);

    beersFound($id3, $conn);

    $goingHome = Distance::between($lat1, $lon1, $lat3st, $lon3st, $decimals = 1, $unit = 'km');
    $totalDistance = $distance1 + $distance2 + $distance3 + $goingHome;
    echo '<br>';
    echo 'Total distance: ' . $totalDistance . ' km';
}





