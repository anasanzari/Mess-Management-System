<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dm="mess_database";

$conn = new mysqli($servername, $username, $password,$dm);

?>