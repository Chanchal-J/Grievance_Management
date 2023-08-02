
<?php

// This file is used to connect with the database 

$servername = "localhost";
$username = "root";
$password = "";
$database = "complaint";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn || mysqli_connect_error()) {
    die("Sorry connection failed: " . mysqli_connect_error());
} else {
    
}

?>
