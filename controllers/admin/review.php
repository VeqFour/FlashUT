<?php
header('Content-Type: application/json');
session_start();
include_once "../../partials/auth_admin.php";
include_once "../../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$adminId = $_SESSION['user_id']; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$countSql = "SELECT COUNT(*) FROM flashcards f
JOIN review r ON f.flashcard_id = r.flashcard_id
JOIN sections s ON f.section_id = s.section_id
WHERE r.ai_status = 'approved'
  AND r.admin_status = 'pending'
  AND s.instructor_id = ?";

$countStmt = $conn->prepare($countSql);
$countStmt->bind_param("i", $adminId);
$countStmt->execute();
$countStmt->bind_result($total);
$countStmt->fetch();
$countStmt->close();

$totalPages = ceil($total / $limit);

$sql = "SELECT 
    f.flashcard_id,
    f.question,
    f.answer,
    f.section_id,
    s.section_name,
    c.course_name,
    u.firstName,
    u.lastName,
    u.academicID
FROM flashcards f
JOIN review r ON f.flashcard_id = r.flashcard_id
JOIN sections s ON f.section_id = s.section_id
JOIN courses c ON c.course_id = s.course_id
JOIN users u ON f.user_id = u.user_id
WHERE r.ai_status = 'approved'
  AND r.admin_status = 'pending'
  AND s.instructor_id = ?
ORDER BY f.created_at ASC
LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $adminId, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}
$stmt->close();

echo json_encode([
    'reviews' => $reviews,
    'totalPages' => $totalPages,
    "totalPending" =>$total
]);