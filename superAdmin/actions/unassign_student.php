<?php
session_start();
require_once "../../includes/db.php";

if (!isset($_POST['student_id']) || !isset($_POST['section_id'])) {
    header("Location: ../administrator.php?error=Missing data");
    exit();
}

$student_id = $_POST['student_id'];
$section_id = $_POST['section_id'];

$stmt = $conn->prepare("DELETE FROM user_sections WHERE user_id = ? AND section_id = ?");
$stmt->bind_param("ii", $student_id, $section_id);

if ($stmt->execute()) {
    header("Location: ../administrator.php?message=Student unassigned successfully");
} else {
    header("Location: ../administrator.php?error=Failed to unassign student");
}
exit();