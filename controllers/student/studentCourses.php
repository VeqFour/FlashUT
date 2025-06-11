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

if (!isset($_SESSION['courses'])) {
    echo json_encode(["error" => "No courses found in session."]);
    exit();
}

$courses = $_SESSION['courses']; 

$currentSemester = "46-2"; 
$state = isset($_GET['state']) ? $_GET['state'] : '';

if ($state === 'add') {
   
    $courses = array_filter($courses, function ($course) use ($currentSemester) {
        return $course['semester_code'] === $currentSemester;
    });
} elseif (isset($_GET['semester']) && $_GET['semester'] !== "") {
    $semester = $_GET['semester'];
    $courses = array_filter($courses, function ($course) use ($semester) {
        return $course['semester_code'] === $semester;
    });
}


$semestersQuery = $conn->query("SELECT DISTINCT semester_code FROM semesters ORDER BY semester_code DESC");
$semesterOptions = [];
while ($row = $semestersQuery->fetch_assoc()) {
    $semesterOptions[] = $row['semester_code'];
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 4;
$total_courses = count($courses);
$totalPages = ceil($total_courses / $limit);
$offset = ($page - 1) * $limit;


 $coursesPaginated = array_slice($courses, $offset, $limit);
 
 echo json_encode([
    "courses" => array_values($coursesPaginated), 
    "totalPages" => $totalPages,
    "semesters" => $semesterOptions,
    "currentSemester"=> $currentSemester
], JSON_UNESCAPED_UNICODE);
exit(); 
?>
