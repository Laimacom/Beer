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

    foreach ($breweries as $key => $brewery) {
        $name = $brewery ['name'];
        if ($id1 == $brewery['id']) {
            echo 'First Brewery is ' . $name . '. Distance ' . $distance1 . 'km';
        }
    }
    echo '<br>';
    echo 'Beers found: ';
    $beers = selectFromBeers($conn);
    foreach ($beers as $key => $beer) {
        //$name = [];
        if ($id1 == $beer['brewery_id']) {
            $name = $beer['name'];
            echo $name . ', ';
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
        if ($id2 == $brewery['id']) {
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
        if ($id3 == $brewery['id']) {
            echo 'Third Brewery is ' . $name . '. Distance ' . $distance3 . 'km';
        }
    }

    $goingHome = Distance::between($lat1, $lon1, $lat3st, $lon3st, $decimals = 1, $unit = 'km');
    $totalDistance = $distance1 + $distance2 + $distance3 + $goingHome;
    echo '<br>';
    echo 'Total distance: ' . $totalDistance . ' km';
}





