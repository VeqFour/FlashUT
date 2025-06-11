<?php
require_once "../../includes/db.php";

header('Content-Type: application/json');

if (isset($_GET['admin_id'])) {
    $admin_id = $_GET['admin_id'];

    $sql = "SELECT s.section_id, s.section_name, c.course_name
            FROM sections s 
            JOIN courses c ON s.course_id = c.course_id
            WHERE s.instructor_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);

} elseif (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $sql = "SELECT s.section_id, s.section_name, c.course_name
            FROM user_sections us
            JOIN sections s ON us.section_id = s.section_id
            JOIN courses c ON s.course_id = c.course_id
            WHERE us.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);

} else {
    echo json_encode([]);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

$sections = [];
while ($row = $result->fetch_assoc()) {
    $sections[] = $row;
}

echo json_encode($sections);