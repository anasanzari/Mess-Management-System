<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dm="mess_database";

// Create connection
$conn = new mysqli($servername, $username, $password,$dm);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

?>