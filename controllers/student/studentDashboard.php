<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
define("ROOT_PATH", dirname(__DIR__));

include_once  "../../includes/db.php"; 
include_once "../../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id']; 

if (isset($_GET['stats']) && $_GET['stats'] == "1") {
    $period = $_GET['period'] ?? 'weekly'; 
    echo json_encode([
        "stats" => [
            "viewed" => getFlashcardStats($conn, $user_id, "view", $period),
            "added"  => getFlashcardStats($conn, $user_id, "add", $period)
        ]
    ], JSON_PRETTY_PRINT);
    exit();
}

if (isset($_GET['state']) && $_GET['state'] == "2") {
    $sql = "SELECT 
                COUNT(*) AS pending_count 
            FROM flashcards f
            JOIN review r ON f.flashcard_id = r.flashcard_id
            WHERE f.user_id = ?
              AND r.admin_status = 'pending'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pending = $result->fetch_assoc();
    $pending_count = $pending['pending_count'];

    echo json_encode([
        "success" => true,
        "pending" => $pending_count
    ]);
    exit;
}

$sql = "SELECT c.*, 
       u.firstName, 
       u.lastName,  
       s.section_name,
       sem.semester_code, 
       sem.semester_name,
       s.section_id,
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
JOIN user_sections us ON s.section_id = us.section_id
WHERE us.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];

while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

$total_courses = count($courses);

$_SESSION['courses'] = $courses;

$topUserId = null;
$sqlTop = "SELECT user_id, COUNT(*) AS total 
            FROM contributions 
            GROUP BY user_id 
            ORDER BY total DESC 
            LIMIT 1";
$resultTop = $conn->query($sqlTop);
if ($rowTop = $resultTop->fetch_assoc()) {
    $topUserId = $rowTop['user_id'];
}

$isTopScorer = ($user_id == $topUserId);

$response = [
    "courses" => $courses, 
    "total_courses" => $total_courses,
    "is_top_scorer" => $isTopScorer
];

header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);


function getFlashcardStats($conn, $user_id, $actionType, $period = 'weekly') {
    $column = "created_at";
    $table = "contributions";

    if ($period === "monthly") {
        $query = "SELECT DATE_FORMAT($column, '%b') AS label, COUNT(*) AS count
                  FROM $table
                  WHERE user_id = ? AND type = ? AND $column >= DATE_SUB(CURDATE(), INTERVAL 5 MONTH)
                  GROUP BY label
                  ORDER BY MIN($column)";
    } else {
        $query = "SELECT DAYNAME($column) AS label, COUNT(*) AS count
                  FROM $table
                  WHERE user_id = ? AND type = ? AND $column >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                  GROUP BY label";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $user_id, $actionType); 
    $stmt->execute();
    $result = $stmt->get_result();

    $labels = [];

    if ($period === "monthly") {
        for ($i = 5; $i >= 0; $i--) {
            $month = date('M', strtotime("-$i months"));
            $labels[$month] = 0;
        }
    } else {
        $labels = [
            "Monday" => 0,
            "Tuesday" => 0,
            "Wednesday" => 0,
            "Thursday" => 0,
            "Friday" => 0,
            "Saturday" => 0,
            "Sunday" => 0
        ];
    }

    while ($row = $result->fetch_assoc()) {
        $labels[$row['label']] = (int)$row['count'];
    }

    return $period === "monthly"
        ? array_slice($labels, -6, 6)
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