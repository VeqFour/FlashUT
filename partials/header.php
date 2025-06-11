<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . "/../includes/db.php";
include "functions.php";


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta charset="utf-8" />
  
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhai&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="/FlashUT/template/img/Favicon.png" />
    <link rel="stylesheet" type="text/css" href="/FlashUT/template/css/navigation.css" />
<link rel="stylesheet" type="text/css" href="/FlashUT/template/css/styleguide.css" />
<link rel="stylesheet" type="text/css" href="/FlashUT/template/css/globals.css" />


  </head>
  <body style="margin: 0; background: #f6f6f6; font-family:Baloo Bhai,sans-serif">
 