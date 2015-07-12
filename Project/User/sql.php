<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'csci4560';
$dbConn = mysqli_connect('p:'.$dbHost, $dbUsername, $dbPassword, $dbName) or die('Error connecting to database');
if (mysqli_connect_errno()) 
  {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
?>
