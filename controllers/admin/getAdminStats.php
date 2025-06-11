<?php
header("Content-Type: application/json");
session_start();
include_once "../../partials/auth_admin.php";
include "../../includes/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_Id = $_SESSION["user_id"];

$sql = "
    SELECT 
        u.user_id,
        u.firstName,
        u.lastName,
        u.academicID,

        (SELECT COUNT(*) 
         FROM flashcards f 
         WHERE f.user_id = u.user_id
        ) AS added_flashcards,

        (SELECT COUNT(*) 
         FROM review r 
         JOIN flashcards f ON r.flashcard_id = f.flashcard_id
         JOIN users u2 ON f.user_id = u2.user_id -- Join to get the flashcard creator's role
         WHERE f.section_id IN (
             SELECT s.section_id 
             FROM sections s 
             WHERE s.instructor_id = u.user_id
         )
         AND r.admin_status IN ('approved', 'rejected')
         AND u2.role = 'student'  
        ) AS reviewed_flashcards

    FROM users u
    WHERE u.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_Id);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    echo json_encode(["success" => true, "user" => $user]);
} else {
    echo json_encode(["success" => false, "message" => "User not found"]);
}
?>