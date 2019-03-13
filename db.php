<?php
function connectDB()
{
    $servername = 'localhost';
    $dbname = 'Beer';
    $username = 'Beer';
    $password = 'LabaiSlaptas123';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die('Nepavyko prisjungti: ' . $conn->connect_error);
    }
    return $conn;
}

function selectFromBreweries($conn){
    $row = [];
    $sql = "SELECT * FROM breweries WHERE id = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    var_dump($row);
    return $row;
}
function selectLatLon($conn){
    $row = [];
    $sql = "SELECT * FROM geocodes WHERE id = 3";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    var_dump($row);
    return $row;
}

$conn = connectDB();
selectFromBreweries($conn);
echo '<br>';
$row = selectLatLon($conn);
$lat2 = $row['latitude'];
$lon2 = $row['longitude'];

$lat1 = 51.355468;
$lon1 = 11.100790;

function getDistanceBetweenPointsNew($lat1, $lon1, $lat2, $lon2, $unit = 'Km') {
    $theta = $lon1 - $lon2;
    $distance = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515;
    switch($unit) {
        case 'Mi': break;
        case 'Km' : $distance = $distance * 1.609344;
    }
    return (round($distance,2));
}
echo '<br>';
echo getDistanceBetweenPointsNew($lat1, $lon1, $lat2, $lon2, $unit = 'Km');

