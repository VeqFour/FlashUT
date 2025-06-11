<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../includes/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: ../login.php");
    exit();
}

$course_id = $_POST['course_id'] ?? '';
$section_name = trim($_POST['section_name'] ?? '');
$semester_id = $_POST['semester_id'] ?? '';

if (!$course_id || !$section_name || !$semester_id) {
    die("Missing course, section name, or semester.");
}
$checkSql = "SELECT * FROM sections WHERE course_id = ? AND section_name = ? AND semester_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("isi", $course_id, $section_name, $semester_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    die("This section name already exists for the selected course and semester.");
}

$insertSql = "INSERT INTO sections (course_id,section_name, semester_id, instructor_id) 
        VALUES (?, ?, ?, NULL)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param("isi", $course_id, $section_name, $semester_id);

if ($insertStmt->execute()) {
    header("Location: ../administrator.php?message=Section created successfully.");
    exit();
} else {
    die("Failed to create section: " . $conn->error);
}
?>