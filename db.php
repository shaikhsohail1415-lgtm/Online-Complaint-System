<?php
$host = "127.0.0.1";
$username = "root";
$password = ""; // Set your own local MySQL password if applicable
$database = "complaint_system";
$port = 3307;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");
?>