<?php

/* @author anas anzari */
require 'connection.php';

$_SESSION['loggedin'] = true;
$_SESSION['usertype'] = 'mess';
$_SESSION['messname'] = 'C MESS';
$_SESSION['messid'] = '1001';

$out = [];

 $data = file_get_contents("php://input");
 $data = json_decode($data,TRUE);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {

    if (isset($_GET['querytype'])) {

        $type = $_GET['querytype'];
        if ($_SESSION['usertype'] == 'mess') {
            switch ($type) {
                case 'messcardentry' : $out = messcardentry();
                    break;
                case 'addextra' : $out = addextra();
                    break;
                case 'addleave': $out = addleave();
                    break;
            }
        }else if($_SESSION['usertype']=='student'){
            switch ($type) {
                case 'ratemess': $out = ratemess();break;
                case 'forumpost': $out = forumpost();break;
            }
        }
    } else {
        $out['status'] = 'fail';
        $out['error'] = "querytype not set.";
    }
} else {
    $out['status'] = 'fail';
    $out['error'] = "authentication failure";
}

header('Content-type: text/plain');
echo json_encode($out, JSON_PRETTY_PRINT);


function messcardentry(){
    global $conn;
    global $data;
    $output = [];
    
    if(isset($data['rollno'])){
       
        $rollno = escape($data['rollno']);
        $messid = $_SESSION['messid'];
        $date = date('Y-m-d');
        //verify $rollno has not been joined any mess. <--------------------------------------------
        
        $sql = "insert into messjoins values('$date','$rollno','$messid');";
        if($conn->query($sql)){
            $output['status'] = 'success';
            
        }else{
            $output['status'] = 'fail';
            $output['error'] = 'query error.';
        }
        
    }else{
      $output['status'] = 'fail';
      $output['error'] = "data missing.";  
    }
    
    return $output;
}

function addextra(){
    global $conn;
    global $data;
    $output = [];
    
    if(isset($data['rollno'])&&isset($data['extraid'])){
       
        $rollno = escape($data['rollno']);
        $extraid = escape($data['extraid']);
        $messid = $_SESSION['messid'];
        $date = date("Y-m-d H:i:s");
       
        $sql = "insert into extrastaken values('$date','$rollno','$extraid');";
        if($conn->query($sql)){
            $output['status'] = 'success';
            
        }else{
            $output['status'] = 'fail';
            $output['error'] = 'query error.';
        }
        
    }else{
      $output['status'] = 'fail';
      $output['error'] = "data missing.";  
    }
    
    return $output;
}

function addleave(){
    global $conn;
    global $data;
    $output = [];
    
    if(isset($data['rollno'])&&isset($data['startdate'])&&isset($data['enddate'])){
       
        $rollno = escape($data['rollno']);
        $startdate = escape($data['startdate']);
        $enddate = escape($data['enddate']);
        $messid = $_SESSION['messid'];
        
        $sql = "insert into messcut values(DATE_FORMAT('$startdate', '%Y-%m-%d'),DATE_FORMAT('$enddate','%Y-%m-%d'),'$rollno','$messid');";
        if($conn->query($sql)){
            $output['status'] = 'success';
            
        }else{
            $output['status'] = 'fail';
            $output['error'] = 'query error.';
        }
        
    }else{
      $output['status'] = 'fail';
      $output['error'] = "data missing.";  
    }
    
    return $output;
}

function ratemess(){
    $output = [];
    
    return $output;
}

function forumpost(){
    $output = [];
    
    return $output;
}


?>
