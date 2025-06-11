<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../includes/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: ../login.php");
    exit();
}

$firstName = trim($_POST['firstName'] ?? '');
$lastName = trim($_POST['lastName'] ?? '');
$email = trim($_POST['email'] ?? '');
$academicID = trim($_POST['academicID'] ?? '');
$password = $_POST['password'] ?? '';
$department_id = $_POST['department_id'] ?? '';

if (!$firstName || !$lastName || !$email || !$academicID || !$password || !$department_id) {
    header("Location: ../administrator.php?error=Please fill in all fields.");
    exit();
}

$checkStmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR academicID = ?");
$checkStmt->bind_param("ss", $email, $academicID);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../administrator.php?error=Email or Academic ID already exists.");
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$insertStmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, academicID, password, role, department_id) VALUES (?, ?, ?, ?, ?, 'admin', ?)");
$insertStmt->bind_param("sssssi", $firstName, $lastName, $email, $academicID, $hashedPassword, $department_id);

if ($insertStmt->execute()) {
    header("Location: ../administrator.php?message=Instructor added successfully.");
    exit();
} else {
    header("Location: ../administrator.php?error=Failed to add instructor.");
    exit();
}
?>