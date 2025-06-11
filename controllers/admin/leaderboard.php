<?php
header("Content-Type: application/json");
session_start(); 
include_once "../../partials/auth_admin.php";
include "../../includes/db.php";


if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
}

$order_by = $_GET['sort'] ?? 'score DESC'; 

$allowed = ['add', 'view', 'score'];
$fieldMap = [
    'add' => 'add_count DESC',
    'view' => 'view_count DESC',
    'score' => 'score DESC'
];

$order_sql = $fieldMap[$order_by] ?? 'score DESC';

$sql = "SELECT 
    u.user_id,
    u.firstName,
    u.lastName,
    u.academicID,
    IFNULL(SUM(c.type = 'add'), 0) AS add_count,
    IFNULL(SUM(c.type = 'view'), 0) AS view_count,
    COUNT(c.type) AS score
FROM users u
JOIN user_sections us ON u.user_id = us.user_id
JOIN sections s ON us.section_id = s.section_id
LEFT JOIN contributions c ON u.user_id = c.user_id
WHERE s.instructor_id = ?
  AND u.role = 'student'
GROUP BY u.user_id
ORDER BY $order_sql;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$leaders = [];

while ($row = $result->fetch_assoc()) {
    $leaders[] = $row;
}

echo json_encode([
    "leaders" => $leaders
]);
?>
