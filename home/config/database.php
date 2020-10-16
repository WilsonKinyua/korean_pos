<?php
session_start();
ob_start();
$user       = "root";
$host       = "localhost";
$password   = "";
$database   = "warehouse";


$connection = mysqli_connect($host,$user,$password,$database);

if(!$connection) {
    die("QUERY FAILED" . mysqli_error($connection));
}
