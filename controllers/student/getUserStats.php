<?php
header("Content-Type: application/json");
session_start();
include "../../includes/db.php";
include_once "../../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userId = $_SESSION["user_id"];

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
        WHERE u.user_id = ?
        GROUP BY u.user_id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    echo json_encode(["success" => true, "user" => $user]);
} else {
    echo json_encode(["success" => false, "message" => "User not found"]);
}
?>
