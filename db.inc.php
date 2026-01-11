<?php
$hostname = "localhost";//"localhost" or "
$username = "example_username";//"root" or "admin1"
$password = "********";//"" or "7?90oYd8v"

$dname = "RentalCompanyDB";

$con = mysqli_connect($hostname, $username, $password, $dname);//connect to the database


if (!$con) {//if the connection fails
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
?>