<?php

function isUserLoggedIn(){
     return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function isAdmin() {
    return isset($_SESSION['logged_in'], $_SESSION['role']) 
        && $_SESSION['logged_in'] === true 
        && $_SESSION['role'] === 'admin';
}

function activePage($pageName){
     return str_contains($_SERVER['PHP_SELF'], $pageName) ? "active" : "";
 }


 function userExists($conn,$academicID){
     $sql = "SELECT * FROM users WHERE academicID = '$academicID' LIMIT 1";
    $result = mysqli_query($conn, $sql);
   return mysqli_num_rows($result)>0;
 }


 function emailExists($conn, $email) {
     $sql = "SELECT user_id FROM users WHERE email ='$email' LIMIT 1";
     $result = mysqli_query($conn, $sql);

     return mysqli_num_rows($result)>0;
}

 function registerUser($conn, $firstName, $lastName, $academicID, $department_id, $email, $password, $role){
           $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
           $sql = "INSERT INTO users (firstName, lastName,academicID, department_id, email, password, role)
                   VALUES ('$firstName', '$lastName', '$academicID', '$department_id', '$email', '$hashedPassword', '$role')";
           return $result = mysqli_query($conn, $sql)=="true"; 
               }

 function checkLogin($conn,$academicID){
               $sql = "SELECT * FROM users WHERE academicID =$academicID";
               $result = mysqli_query($conn, $sql);
               return mysqli_num_rows($result) === 1;
               }

?>