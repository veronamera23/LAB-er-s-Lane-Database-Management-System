<?php

$serverName = "localhost";
$dbUserName = "root";
$dbpassword = "";
$dbName = "laberslanedb";

$conn = mysqli_connect($serverName, $dbUserName, $dbpassword, $dbName);

if (!$conn) {
    die("CONNECTION FAILED! " . mysqli_connect_error());
}