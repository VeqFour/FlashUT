<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../includes/db.php'; 
include "../partials/functions.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $academicID = mysqli_real_escape_string($conn, $_POST['academicID']);
    $department_id = mysqli_real_escape_string($conn, $_POST['department_id']);  
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $role = "student"; 

    if ($password !== $confirmPassword) {
        header('Location: ../views/register.php?error=Passwords do not match');
        exit();
    }else{

   

    if (userExists($conn,$academicID)) {
        header('Location: ../views/register.php?error=This Academic ID is already used');
        exit();
    }
        elseif(emailExists($conn,$email)){
            header('Location: ../views/register.php?error=This Email is already registered');
            exit();
        }

     else {
      
                       
        if (registerUser($conn, $firstName, $lastName, $academicID, $department_id, $email, $password, $role)) {
            header("Location: ../views/login.php?success=Account created successfully, login now");
            exit();
        } else {
            echo " Error inserting data: " . mysqli_error($conn); 
        }
    }
  }
}

            
mysqli_close($conn);
?>