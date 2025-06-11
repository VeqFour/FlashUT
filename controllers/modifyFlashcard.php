<?php
session_start();
include "../includes/db.php";
require "ai_review.php";
include_once "../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_SESSION['user_id'];
    $flashcard_id = intval($_POST['flashcard_id']);
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);

    if ($question === "" || $answer === "") {
        echo json_encode(["success" => false, "message" => "Incomplete fields"]);
        exit;
    }

    $courseQuery = $conn->prepare("SELECT c.course_name, f.section_id FROM flashcards f JOIN sections s ON f.section_id = s.section_id JOIN courses c ON s.course_id = c.course_id WHERE f.flashcard_id = ?");
    $courseQuery->bind_param("i", $flashcard_id);
    $courseQuery->execute();
    $courseData = $courseQuery->get_result()->fetch_assoc();
    $section_id = $courseData['section_id'];
    $course_name = $courseData['course_name'];
    $courseQuery->close();

    $examples = [];
    $stmt = $conn->prepare("SELECT question, answer FROM flashcards WHERE section_id = ? AND flashcard_id != ? LIMIT 10");
    $stmt->bind_param("ii", $section_id, $flashcard_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($r = $result->fetch_assoc()) {
        $examples[] = "- Q: {$r['question']} | A: {$r['answer']}";
    }
    $stmt->close();

    $exampleText = implode("\n", $examples);
    $feedback = reviewFlashcardWithAI($course_name, $question, $answer, $exampleText);

    if (preg_match('/Verdict:\s*(approve|reject)/i', $feedback, $match)) {
        $ai_status = strtolower($match[1]) === 'approve' ? 'approved' : 'rejected';
    } else {
        $ai_status = 'rejected';
    }
    $admin_status = ($ai_status === 'approved') ? 'pending' : NULL;

    $updateStmt = $conn->prepare("UPDATE flashcards SET question = ?, answer = ? WHERE flashcard_id = ? AND user_id = ?");
$updateStmt->bind_param("ssii", $question, $answer, $flashcard_id, $user_id);
$updateStmt->execute();

$updateReview = $conn->prepare("UPDATE review SET ai_status = ?, ai_feedback = ?, admin_status = ? WHERE flashcard_id = ?");
$updateReview->bind_param("sssi", $ai_status, $feedback, $admin_status, $flashcard_id);
$updateReview->execute();

    echo json_encode([
        "success" => true,
        "status" => $ai_status,
        "feedback" => $feedback
    ]);
}
?>