<?php
$host = "localhost";
$dbname = "mini_note"; 
$username = "root"; 
$password = "";     

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
session_start(); 
?>