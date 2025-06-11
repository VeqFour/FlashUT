<?php
header("Content-Type: application/json");
session_start();
include_once "../../partials/auth_admin.php";
include "../../includes/db.php"; 


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(["error" => "Admin not logged in"]);
    exit;
}
if (!isset($_SESSION['user_id'])|| $_SESSION['role']!=="admin") {
    echo json_encode(["error" => "Admin not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id']; 

if (!isset($_SESSION['courses'])) {
    echo json_encode(["error" => "No courses found in session."]);
    exit();
}

$courses = $_SESSION['courses']; 


if (isset($_GET['semester']) && $_GET['semester'] !== "") {
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

// if (isset($_GET['search'])) {
//     $searchTerm = strtolower(trim($_GET['search']));
//     $courses = array_filter($courses, function ($course) use ($searchTerm) {
//         return strpos(strtolower($course['course_name']), $searchTerm) !== false;
//     });
// }

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 4;
$total_courses = count($courses);
$totalPages = ceil($total_courses / $limit);
$offset = ($page - 1) * $limit;


 $coursesPaginated = array_slice($courses, $offset, $limit);

echo json_encode([
    "courses" => array_values($coursesPaginated), 
    "totalPages" => $totalPages,
    "semesters" => $semesterOptions
], JSON_UNESCAPED_UNICODE);
exit(); 
?>
