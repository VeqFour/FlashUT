<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once "../includes/db.php";
include_once "../partials/functions.php";
require "ai_review.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);
    $sectionId = intval($_POST['section_id']);

    $sectionQuery = $conn->prepare("
        SELECT s.course_id, c.course_name 
        FROM sections s 
        JOIN courses c ON s.course_id = c.course_id 
        WHERE s.section_id = ?
        ");
    $sectionQuery->bind_param("i", $sectionId);
    $sectionQuery->execute();
    $sectionResult = $sectionQuery->get_result();
    $sectionData = $sectionResult->fetch_assoc();

    $courseId = $sectionData['course_id'] ?? 0;
    $courseName = $sectionData['course_name'] ?? 'Unknown Course';

    $sectionQuery->close();

    if ($question === "" || $answer === "" || !$sectionId || !$courseId ||!$courseName) {
        echo "Invalid data.";
        exit;
    }



    $existingStmt = $conn->prepare("
    SELECT f.question, f.answer 
    FROM flashcards f
    JOIN groups g ON f.group_id = g.group_id
    WHERE g.section_id = ?
    LIMIT 10
       ");
    $existingStmt->bind_param("i", $sectionId);
    $existingStmt->execute();
    $existingResult = $existingStmt->get_result();

    $existingFlashcards = [];
    while ($row = $existingResult->fetch_assoc()) {
        $existingFlashcards[] = "- Q: {$row['question']} | A: {$row['answer']}";
    }
    $existingStmt->close();

    $stmt = $conn->prepare("INSERT INTO flashcards (user_id, section_id, question, answer) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $userId, $sectionId, $question, $answer);

    if ($stmt->execute()) {
        $flashcardId = $stmt->insert_id;

        // if ($role === "admin") {
        //     $review = $conn->prepare("INSERT INTO review (flashcard_id, ai_status, admin_status, ai_feedback, admin_feedback) VALUES (?, 'approved', 'approved', 'Auto-approved for admin', 'Approved by admin')");
        //     $review->bind_param("i", $flashcardId);
        //     $review->execute();
        //     $review->close();

          
      
               
             $similarExamples = implode("\n", $existingFlashcards);

            $aiFeedback = reviewFlashcardWithAI($courseName, $question, $answer, $similarExamples);
            $aiStatus = stripos($aiFeedback, 'reject') !== false ? 'rejected' : 'approved';

            $adminStatus = ($aiStatus === 'approved') ? 'pending' : NULL;


            $review = $conn->prepare("INSERT INTO review (flashcard_id, ai_status, admin_status, ai_feedback) VALUES (?, ?, ? , ?)");
            $review->bind_param("isss", $flashcardId, $aiStatus,$adminStatus, $aiFeedback);
            $review->execute();
            $review->close();
        

        echo json_encode([
            "success" => true,
            "status" => $aiStatus ?? 'approved', 
            "feedback" => $aiFeedback ?? 'No feedback'
        ]);    } else {
            echo json_encode(["success" => false, "message" => "Failed to submit flashcard."]);
        
        }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);}