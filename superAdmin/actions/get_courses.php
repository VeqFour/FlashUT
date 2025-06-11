<?php
require_once "../../includes/db.php";

$department_id = $_GET['department_id'] ?? '';

if (!$department_id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT course_id, course_name FROM courses WHERE department_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $department_id);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

header('Content-Type: application/json');
echo json_encode($courses);
?>