<?php
session_start();
session_destroy(); // Wipes the memory of who was logged in
header("Location: index.php"); // Sends you back to the login page
?>