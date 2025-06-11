<?php
session_start();
require_once "../../includes/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: ../login.php");
    exit();
}

$admin_id = $_POST['admin_id'] ?? '';

if (!$admin_id) {
    header("Location: ../administrator.php?error=No instructor selected.");
    exit();
}

$check = $conn->prepare("SELECT COUNT(*) FROM sections WHERE instructor_id = ?");
$check->bind_param("i", $admin_id);
$check->execute();
$check->bind_result($count);
$check->fetch();
$check->close();

if ($count > 0) {
    header("Location: ../administrator.php?error=Cannot delete. Instructor assigned to sections.");
    exit();
}

// Delete instructor
$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ? AND role = 'admin'");
$stmt->bind_param("i", $admin_id);

if ($stmt->execute()) {
    header("Location: ../administrator.php?message=Instructor deleted successfully.");
} else {
    header("Location: ../administrator.php?error=Failed to delete instructor.");
}
exit();
?>