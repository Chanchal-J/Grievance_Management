<?php

//To logout from the session and update the super global variable $_SESSION

session_start();
unset($_SESSION['loggedin']);
session_destroy();
header('location:/project/index.php');
?>