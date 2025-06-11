<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json'); 
session_start();
include "../includes/db.php"; 
include_once "../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

if (!isset($_GET['group_id'], $_GET['group_name'])) {
    echo json_encode(["error" => "Missing parameters."]);
    exit();
}


$user = $_SESSION['user'];
// $section_id = intval($_GET['section_id']);
$group_id = intval($_GET['group_id']);
$group_name = urldecode($_GET['group_name']);

if (isset($_SESSION['course'])) {
    $course = $_SESSION['course'];
} else {
    $course = [
        "section_id" => $_GET['section_id'] ?? null,
        "course_name" => isset($_GET['course_name']) ? urldecode($_GET['course_name']) : "Unknown",
        "image_path" => $_GET['course_image'] ?? "default-course.jpg"
    ];
}

$sql = "SELECT f.*, u.firstName, u.lastName, u.role 
        FROM flashcards f
        JOIN users u ON f.user_id = u.user_id
        JOIN review r ON f.flashcard_id = r.flashcard_id
        WHERE f.group_id = ?
          AND r.ai_status = 'approved' AND r.admin_status = 'approved'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $group_id);
$stmt->execute();
$result = $stmt->get_result();

$flashcards = [];

while ($row = $result->fetch_assoc()) {
    $viewCheckStmt = $conn->prepare("SELECT 1 FROM contributions WHERE flashcard_id = ? AND user_id = ? AND type = 'view'");
    $viewCheckStmt->bind_param("ii", $row['flashcard_id'], $user['user_id']);
    $viewCheckStmt->execute();
    $viewCheckStmt->store_result();

    $row['viewed'] = $viewCheckStmt->num_rows > 0;
    $flashcards[] = $row;
    $viewCheckStmt->close();
}

$response = [
    "flashcards" => $flashcards,
    "group_name" => $group_name,
    "course" => $course,
    "user" => $user
];

echo json_encode($response, JSON_PRETTY_PRINT);
exit();
?>