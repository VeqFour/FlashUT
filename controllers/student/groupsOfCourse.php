<?php
header("Content-Type: application/json");
session_start();
include "../../includes/db.php"; 
include_once "../../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}
$user_id = $_SESSION['user_id'];




if (!isset($_GET['section_id'])) {
    echo json_encode(["error" => "Section not selected"]);
    exit;
}
$section_id = intval($_GET['section_id']);




$courseQuery = "SELECT 
                    c.course_name, 
                    u.firstName, 
                    u.lastName, 
                    c.image_path 
                FROM courses c
                JOIN sections s ON c.course_id = s.course_id
                JOIN users u ON s.instructor_id = u.user_id
                WHERE s.section_id = ? 
                  AND s.section_id IN (
                        SELECT section_id FROM user_sections WHERE user_id = ?
                  )
               ";

$stmt = $conn->prepare($courseQuery);
$stmt->bind_param("ii", $section_id, $user_id);
$stmt->execute();
$courseResult = $stmt->get_result();
$course = $courseResult->fetch_assoc();
$stmt->close();


$_SESSION['course']=$course;






$groupsQuery = "SELECT g.group_id, g.group_name, 
                (
                    SELECT COUNT(*) 
                    FROM flashcards f
                    JOIN review r ON r.flashcard_id = f.flashcard_id
                    WHERE f.group_id = g.group_id
                      AND r.ai_status = 'approved'
                      AND r.admin_status = 'approved'
                ) AS flashcard_count 
                FROM groups g
                WHERE g.section_id = ?";
                
$stmt = $conn->prepare($groupsQuery);
$stmt->bind_param("i", $section_id,);
$stmt->execute();
$result = $stmt->get_result();

$groups = [];
while ($row = $result->fetch_assoc()) {
    $groups[] = $row;
}
$stmt->close();

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 4;
$total_groups = count($groups);
$totalPages = ceil($total_groups / $limit);
$offset = ($page - 1) * $limit;

$groupsPaginated = array_slice($groups, $offset, $limit);

$favStmt = $conn->prepare("SELECT group_id FROM favorite_groups WHERE user_id = ?");
$favStmt->bind_param("i", $user_id);
$favStmt->execute();
$favResult = $favStmt->get_result();

$favGroups = [];
while ($fav = $favResult->fetch_assoc()) {
    $favGroups[] = $fav['group_id'];
}
$favStmt->close();




$response = [
    "course" => $course,  
    "groups" => $groupsPaginated,
    "total" => $total_groups,
    "totalPages" => $totalPages,
    "favorites" =>$favGroups

    
];

header("Content-Type: application/json");
echo json_encode($response,JSON_PRETTY_PRINT);
exit;
?>
