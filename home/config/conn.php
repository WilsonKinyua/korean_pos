<?php
session_start();
ob_start();
$user       = "root";
$host       = "localhost";
$password   = "";
$database   = "pos";


$conn = mysqli_connect($host,$user,$password,$database);

if(!$conn) {
    die("QUERY FAILED" . mysqli_error($conn));
}
