<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'CFCWA';


$conn = mysqli_connect($host, $username, $password, $dbname);

if ($conn) {
    //echo "Connected";
}else {
      echo "Failed connection" . mysqli_connect_error($conn);
}
?>