<?php

$conn = mysqli_connect("localhost:3307", "root", "", "admin");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

?>