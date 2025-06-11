<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../includes/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: ../login.php");
    exit();
}

$admin_id = $_POST['admin_id'] ?? '';
$section_id = $_POST['section_id'] ?? '';

if (!$admin_id || !$section_id) {
    die("Missing instructor or section selection.");
}

$checkSql = "SELECT * FROM sections WHERE section_id = ? AND instructor_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $section_id, $admin_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    die("This instructor is already assigned to this section.");
}

$updateSql = "UPDATE sections SET instructor_id = ? WHERE section_id = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("ii", $admin_id, $section_id);

if ($updateStmt->execute()) {
    header("Location: ../administrator.php?message=Instructor assigned successfully.");
    exit();
} else {
    die("Failed to assign instructor: " . $conn->error);
}
?>