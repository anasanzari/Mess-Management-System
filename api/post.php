<?php

/* @author anas anzari */
require 'connection.php';

$_SESSION['loggedin'] = true;
$_SESSION['usertype'] = 'mess';
$_SESSION['messname'] = 'C MESS';
$_SESSION['messid'] = '1001';

$out = [];

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] && isset($_GET['usertype']) && $_SESSION['usertype'] == $_GET['usertype']) {

    if (isset($_GET['querytype'])) {

        $type = $_GET['querytype'];
        if ($_GET['usertype'] == 'mess') {
            switch ($type) {
                case 'messcardentry' : $out = messcardentry();
                    break;
                case 'addextra' : $out = addextra();
                    break;
                case 'addleave': $out = addleave();
                    break;
            }
        }else if($_GET['usertype']=='student'){
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
    $output = [];
    
    return $output;
}

function addextra(){
    $output = [];
    
    return $output;
}

function addleave(){
    $output = [];
    
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
