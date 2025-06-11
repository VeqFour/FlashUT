<?php
header("Content-Type: application/json");
session_start();
include "../../includes/db.php";
include_once "../../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user']['user_id'];

$sql = "
   SELECT 
    f.flashcard_id,
    f.question,
    f.answer,
    f.section_id,
    c.course_name,
    r.ai_status,
    r.admin_status,
    r.ai_feedback,
    r.admin_feedback
FROM flashcards f
JOIN review r ON f.flashcard_id = r.flashcard_id
JOIN sections s ON f.section_id = s.section_id
JOIN courses c ON s.course_id = c.course_id
WHERE f.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$pending = [];
$approved = [];
$rejected = [];

while ($row = $result->fetch_assoc()) {
    $base = [
        'flashcard_id' => $row['flashcard_id'],
        'question' => $row['question'],
        'answer' => $row['answer'],
        'section_id' => $row['section_id'],
        'course_name' => $row['course_name']
    ];

    if ($row['ai_status'] === 'approved' && $row['admin_status'] === 'pending') {
        $pending[] = $base;
    } elseif ($row['ai_status'] === 'approved' && $row['admin_status'] === 'approved') {
        $approved[] = $base;
    } elseif ($row['ai_status'] === 'rejected' || $row['admin_status'] === 'rejected') {
        $rejected_by = ($row['admin_status'] === 'rejected') ? 'Admin' : 'AI';
        $feedback = ($row['admin_status'] === 'rejected') ? $row['admin_feedback'] : $row['ai_feedback'];

        $rejected[] = array_merge($base, [
            'answer' => $row['answer'],
            'rejected_by' => $rejected_by,
            'feedback' => $feedback
        ]);
    }
}
$stmt->close();

$response = [
    "success" => true,
    "pending" => $pending,
    "approved" => $approved,
    "rejected" => $rejected
];

echo json_encode($response, JSON_PRETTY_PRINT);
exit();
