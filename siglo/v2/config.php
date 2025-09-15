<?php

$servername = "localhost";
$username = "onyx";
$password = "onyxpwd123";
$dbname = "onyx";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}

?>
