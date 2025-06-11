<?php
header("Content-Type: application/json");
session_start();
error_reporting(E_ALL);
  ini_set('display_errors', 1);
include "../../includes/db.php";
include_once "../../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "
SELECT 
  g.group_id, 
  g.group_name, 
  g.section_id, 
  c.course_name,
  c.image_path,  
  (SELECT COUNT(*) FROM flashcards f 
    JOIN review r ON f.flashcard_id = r.flashcard_id 
    WHERE f.group_id = g.group_id AND r.ai_status = 'approved' AND r.admin_status = 'approved') AS flashcard_count
FROM favorite_groups fg
JOIN groups g ON fg.group_id = g.group_id
JOIN sections s ON g.section_id = s.section_id
JOIN courses c ON s.course_id = c.course_id
WHERE fg.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$groups = [];
while ($row = $result->fetch_assoc()) {
    $groups[] = $row;
}

$favStmt = $conn->prepare("SELECT group_id FROM favorite_groups WHERE user_id = ?");
$favStmt->bind_param("i", $user_id);
$favStmt->execute();
$favResult = $favStmt->get_result();

$favGroups = [];
while ($fav = $favResult->fetch_assoc()) {
    $favGroups[] = $fav['group_id'];
}
$favStmt->close();

echo json_encode([
    "success" => true,
    "groups" => $groups,
    "count" => count($groups),
    "favorites" => $favGroups
]);
?>