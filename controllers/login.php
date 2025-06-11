<?php
session_start();
session_regenerate_id(true); 

require_once  '../includes/db.php';
require_once  '../partials/functions.php';


if (isUserLoggedIn()) {
    $name = $_SESSION['firstName'];

    if ($_SESSION['role'] === "admin") {
        header("Location: ../views/admin/adminDashboard.php?message=Welcome D. $name");
    } else {
        header("Location: ../views/student/studentDashboard.php?message=Welcome $name");
    }
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $academicID = mysqli_real_escape_string($conn, $_POST['academicID']);
    $password   = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE academicID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $academicID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['logged_in']   = true;
            $_SESSION['user_id']     = $user['user_id'];
            $_SESSION['academicID']  = $user['academicID'];
            $_SESSION['role']        = $user['role'];
            $_SESSION['firstName']   = $user['firstName'];
            $_SESSION['lastName']    = $user['lastName'];
            $_SESSION['pic_path']    = $user['pic_path'];
        
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'firstName' => $user['firstName'],
                'lastName' => $user['lastName'],
                'email' => $user['email'],
                'role' => $user['role'],
                'pic_path' => $user['pic_path'] ?? "userpic.svg"
            ];
        
            $name = $user['firstName'];
        
            if ($user['role'] === 'superadmin') {
                header("Location: ../superAdmin/administrator.php?message=Welcome Superadmin $name");
            } else if ($user['role'] === 'admin') {
                header("Location: ../views/admin/adminDashboard.php?message=Welcome D. $name");
            } else {
                header("Location: ../views/student/studentDashboard.php?message=Welcome $name");
            }
            exit();
        
        } else {
            header("Location: ../views/login.php?error=Invalid password");
            exit();
        }
    } else {
        header("Location: ../views/login.php?error=User not found");
        exit();
    }
}

$conn->close();
?>