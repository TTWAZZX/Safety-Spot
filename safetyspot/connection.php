<?php

$host = "localhost";

 $username = "root" ;
 $password="";
 $dbName="safety_spot_db";
// Create connection
$conn = mysqli_connect($host, $username, $password,$dbName);
mysqli_set_charset($conn, 'utf8');
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}



?>

