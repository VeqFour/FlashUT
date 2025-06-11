<?php
require_once "../../includes/db.php";

$student_id = $_GET['student_id'] ?? '';
$department_id = $_GET['department_id'] ?? '';

if (!$student_id || !$department_id) {
    echo json_encode([]);
    exit;
}

$sql = "
   SELECT s.section_id, s.section_name, c.course_name
    FROM sections s
    JOIN courses c ON s.course_id = c.course_id
    WHERE c.department_id = ?
    AND s.section_id NOT IN (
        SELECT section_id FROM user_sections WHERE user_id = ?
    )
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $department_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

$sections = [];
while ($row = $result->fetch_assoc()) {
    $sections[] = $row;
}

header('Content-Type: application/json');
echo json_encode($sections);