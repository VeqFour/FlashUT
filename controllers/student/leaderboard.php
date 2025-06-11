<?php
header("Content-Type: application/json");
session_start(); 
include "../../includes/db.php";
include_once "../../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
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
    LEFT JOIN contributions c ON u.user_id = c.user_id
    WHERE u.role = 'student'
    GROUP BY u.user_id
   ORDER BY $order_sql;";

$result = $conn->query($sql);
$leaders = [];

while ($row = $result->fetch_assoc()) {
    $leaders[] = $row;
}

echo json_encode([
    "current_user_id" => $_SESSION['user_id'],
    "leaders" => $leaders
]);
?>
