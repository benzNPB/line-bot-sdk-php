<?php
$servername = "us-cdbr-iron-east-04.cleardb.net";
$username = "bf77fe5230f3fe";
$password = "c963cd151a552ea";
$dbname = "heroku_8b2a3c1ec4fd3a5";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>