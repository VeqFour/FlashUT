<?php
require_once "../../includes/db.php";

$department_id = $_GET['department_id'] ?? '';

if (!$department_id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT user_id, firstName, lastName, email 
        FROM users 
        WHERE role = 'admin' 
        AND department_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $department_id);
$stmt->execute();
$result = $stmt->get_result();

$admins = [];
while ($row = $result->fetch_assoc()) {
    $admins[] = $row;
}

header('Content-Type: application/json');
echo json_encode($admins);