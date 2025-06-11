<?php
require_once "../../includes/db.php";

$department_id = $_GET['department_id'] ?? '';

if (!$department_id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT user_id, firstName, lastName, academicID 
        FROM users 
        WHERE role = 'student' 
        AND department_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $department_id);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

header('Content-Type: application/json');
echo json_encode($students);