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

function selectDB($conn){
    $row = [];
    $sql = "SELECT * FROM breweries WHERE id = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    var_dump($row);
    return $row;
}

$conn = connectDB();
selectDB($conn);

