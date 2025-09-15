<?php

$servername = "localhost";
$username = "onyx";
$password = "db0nyxCibanc0";
$dbname = "onyx2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}

?>
