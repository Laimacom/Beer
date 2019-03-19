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
function selectLatLon($conn)
{
    $sql = "SELECT * FROM geocodes";
    $result = $conn->query($sql);
    $items = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            $items[] = $row;
        }
        //var_dump($items);
    }
    return $items;
}
function selectFromBreweries($conn)
{
    $sql = "SELECT * FROM breweries";
    $result = $conn->query($sql);
    $breweries = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $breweries[] = $row;
        }
        //var_dump($breweries);
    }
    return $breweries;
}

function selectFromBeers($conn)
{
    $sql = "SELECT * FROM beers";
    $result = $conn->query($sql);
    $breweries = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $beers[] = $row;
        }
    }
    return $beers;
}

function breweries($breweries, $id, $number, $distance)
{
    foreach ($breweries as $key => $brewery) {
        $name = $brewery ['name'];
        if ($id == $brewery['id']) {
            echo $number . ' Brewery is ' . $name . '. Distance ' . $distance . 'km';
        }
    }
}

function beersFound($id, $conn)
{
    echo '<br>';
    echo 'Beers found: ';
    $beers = selectFromBeers($conn);
    foreach ($beers as $key => $beer) {
        if ($id == $beer['brewery_id']) {
            $name = $beer['name'];
            echo $name . ', ';
        }
    }
}

