<?php
if($_SESSION[usertype]=='student'){
    unset($_SESSION['usertype']);
    unset($_SESSION['name']);
    unset($_SESSION['rollno']);
}else{
  unset($_SESSION['usertype']);
  unset($_SESSION['messname']);
  unset($_SESSION['mess_id']);  
}
unset($_SESSION['loggedin']);
header("Location: login.php");

?>

