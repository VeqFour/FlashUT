<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once "functions.php";
if (!isAdmin()) {
    header("Location:/FlashUT/views/login.php?message=You are not allowed");
    exit();
}
?>