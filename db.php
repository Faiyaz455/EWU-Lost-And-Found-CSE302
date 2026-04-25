<?php
// Start a session so the system remembers who is logged in
session_start(); 

$host = "localhost";
$user = "root"; // Default XAMPP username
$pass = "";     // Default XAMPP password is empty
$dbname = "ewu_lost_found";

// Connect to the database
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if it worked
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>