<?php
session_start();
require_once "../../includes/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: ../login.php");
    exit();
}

$admin_id = $_POST['admin_id'] ?? '';
$section_id = $_POST['section_id'] ?? '';

if (!$admin_id || !$section_id) {
    header("Location: ../administrator.php?error=Missing instructor or section.");
    exit();
}

$check = $conn->prepare("SELECT * FROM sections WHERE section_id = ? AND instructor_id = ?");
$check->bind_param("ii", $section_id, $admin_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    header("Location: ../administrator.php?error=Instructor is not assigned to this section.");
    exit();
}

$update = $conn->prepare("UPDATE sections SET instructor_id = NULL WHERE section_id = ?");
$update->bind_param("i", $section_id);

if ($update->execute()) {
    header("Location: ../administrator.php?message=Instructor unassigned from section successfully.");
} else {
    header("Location: ../administrator.php?error=Failed to unassign instructor.");
}
exit();
?>