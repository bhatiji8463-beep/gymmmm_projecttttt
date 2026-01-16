<?php
$conn = mysqli_connect("localhost","root","","gym_project");
if(!$conn){
    die("Database connection failed");
}
session_start();
?>
