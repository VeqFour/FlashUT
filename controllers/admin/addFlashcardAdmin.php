<?php
header("Content-Type: application/json");
session_start();
include_once "../../partials/auth_admin.php";
include_once "../../includes/db.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    echo "User not logged in.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);
    $sectionId = intval($_POST['section_id']);
    $groupId = intval($_POST['group_id']);

    if ($question === "" || $answer === "" || !$sectionId || !$groupId) {
        echo "Invalid data.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO flashcards (user_id, section_id, group_id, question, answer) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $userId, $sectionId, $groupId, $question, $answer);

    if ($stmt->execute()) {
        $flashcardId = $stmt->insert_id;

        $review = $conn->prepare("INSERT INTO review (flashcard_id, ai_status, admin_status, ai_feedback, admin_feedback) VALUES (?, 'approved', 'approved', 'Auto-approved for admin', 'Approved by admin')");
        $review->bind_param("i", $flashcardId);
        $review->execute();
        $review->close();

        $stmt->close();
        echo "success";
    } else {
        $stmt->close();
        echo "Failed to insert flashcard.";
    }
} else {
    echo "Invalid request method.";
}