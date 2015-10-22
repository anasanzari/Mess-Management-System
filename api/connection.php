<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dm="mess_database";


 function escape($value){
         return mysql_real_escape_string($value);
 }

$conn = new mysqli($servername, $username, $password,$dm);

?>