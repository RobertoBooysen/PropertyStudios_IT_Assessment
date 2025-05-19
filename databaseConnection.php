<?php
session_start(); // Start session

//Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "propertyStudios_db";

//Creating connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Checking connection
if ($conn->connect_error) {
    //Connection failed
    //die("Connection failed: " . $conn->connect_error);
} else {
    //Connection successful
    //echo "Connected successfully <br>";
}
?>