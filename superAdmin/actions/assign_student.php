<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../includes/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: ../../login.php");
    exit();
}

$student_id = $_POST['student_id'] ?? '';
$section_id = $_POST['section_id'] ?? '';

if (!$student_id || !$section_id) {
    header("Location: administrator.php?error=Missing student or section selection.");
    exit();
}

$checkSql = "SELECT * FROM user_sections WHERE user_id = ? AND section_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $student_id, $section_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    header("Location: ../administrator.php?error=This student is already assigned to this section.");
    exit();
}

$insertSql = "INSERT INTO user_sections (user_id, section_id) VALUES (?, ?)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param("ii", $student_id, $section_id);

if ($insertStmt->execute()) {
    header("Location: ../administrator.php?message=Student assigned successfully.");
    exit();
} else {
    header("Location: ../administrator.php?error=Failed to assign student: " . urlencode($conn->error));
    exit();
}
?>