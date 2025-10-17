<?php

namespace App\Models;

$servername = "localhost";
$username = "proyecto";
$password = "12345";
$dbname = "priroda";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>