<?php
header("Content-Type: application/json");
session_start();
include_once "../../partials/auth_admin.php";
include "../../includes/db.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['state']) && $_GET['state'] == "2") {
    $sql = "SELECT 
                COUNT(*) AS review_count 
            FROM flashcards f
            JOIN review r ON f.flashcard_id = r.flashcard_id
            JOIN sections s ON f.section_id = s.section_id
            WHERE s.instructor_id = ?
              AND r.admin_status = 'pending'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);  
    $stmt->execute();
    $result = $stmt->get_result();
    $review = $result->fetch_assoc();
    $review_count = $review['review_count'] ?? 0;

    echo json_encode([
        "success" => true,
        "review" => $review_count
    ]);
    exit;
}
if (isset($_GET['stats'])&& $_GET['stats'] == "1") {
    $period = $_GET['period'] ?? 'weekly';

    echo json_encode([
        "stats" => [
            "added" => getAdminStats($conn, $user_id, "added", $period),
            "reviewed" => getAdminStats($conn, $user_id, "reviewed", $period),
        ]
    ], JSON_PRETTY_PRINT);
    exit();
}

$stmt = $conn->prepare("
     SELECT c.*, 
           u.firstName, 
           u.lastName,
           s.section_id,
           s.section_name,
           sem.semester_code, 
           sem.semester_name,
            (
         SELECT COUNT(*) 
         FROM review r 
         JOIN flashcards f ON r.flashcard_id = f.flashcard_id  
         WHERE f.section_id = s.section_id 
           AND r.admin_status = 'approved'
       ) AS total_flashcards
    FROM courses c
    JOIN sections s ON c.course_id = s.course_id
    JOIN semesters sem ON s.semester_id = sem.semester_id
    JOIN users u ON s.instructor_id = u.user_id
    WHERE s.instructor_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}
$_SESSION['courses'] = $courses;

echo json_encode([
    "success" => true,
    "courses" => $courses,
    "total" => count($courses)
], JSON_PRETTY_PRINT);


function getAdminStats($conn, $admin_id, $type, $period = 'weekly') {
    if ($type === 'added') {
        $table = "flashcards";
        $column = "created_at";
        $condition = "user_id = ?";
    } elseif ($type === 'reviewed') {
        $table = "review";
        $column = "reviewed_at";
        $condition = "admin_id = ? AND admin_status != 'pending' AND reviewed_at IS NOT NULL";
    } else {
        return [];
    }

    if ($period === 'monthly') {
        $query = "SELECT DATE_FORMAT($column, '%b') AS label, COUNT(*) AS count
                  FROM $table
                  WHERE $condition AND $column >= DATE_SUB(CURDATE(), INTERVAL 5 MONTH)
                  GROUP BY label
                  ORDER BY MIN($column)";
    } else {
        $query = "SELECT DAYNAME($column) AS label, COUNT(*) AS count
                  FROM $table
                  WHERE $condition AND $column >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                  GROUP BY label";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $labels = ($period === "monthly")
        ? array_fill_keys(array_map(fn($i) => date('M', strtotime("-$i months")), range(5, 0)), 0)
        : ["Monday"=>0,"Tuesday"=>0,"Wednesday"=>0,"Thursday"=>0,"Friday"=>0,"Saturday"=>0,"Sunday"=>0];

    while ($row = $result->fetch_assoc()) {
        $labels[$row['label']] = (int)$row['count'];
    }

    return ($period === "monthly")
        ? array_slice($labels, -6)
        : [
            "sun" => $labels["Sunday"],
            "mon" => $labels["Monday"],
            "tue" => $labels["Tuesday"],
            "wed" => $labels["Wednesday"],
            "thu" => $labels["Thursday"],
            "fri" => $labels["Friday"],
            "sat" => $labels["Saturday"],
        ];
}