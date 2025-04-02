<?php
// db.php - Database Connection File

$host = 'localhost';
$username = 'root';
$password = 'A@sherman1234!'; // Change this if your MySQL setup has a password
$dbname = 'ride_sharing';

// Establishing connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
