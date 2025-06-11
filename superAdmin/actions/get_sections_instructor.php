<?php
require_once "../../includes/db.php";

$department_id = $_GET['department_id'] ?? '';

if (!$department_id) {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT s.section_id, s.section_name, c.course_name 
    FROM sections s 
    JOIN courses c ON s.course_id = c.course_id
    WHERE c.department_id = ? 
    AND (s.instructor_id IS NULL OR s.instructor_id = 0)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $department_id);
$stmt->execute();
$result = $stmt->get_result();

$sections = [];
while ($row = $result->fetch_assoc()) {
    $sections[] = $row;
}

header('Content-Type: application/json');
echo json_encode($sections);
?>