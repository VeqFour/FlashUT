<?php
header('Content-Type: application/json');
session_start();
include "../includes/db.php";
include_once "../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}
$user_id = $_SESSION['user_id'];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $flashcard_id = $data['flashcard_id'] ?? null;
    $content = trim($data['content'] ?? '');
    
    if (!$flashcard_id || empty($content)) {
        echo json_encode(["error" => "Missing required fields"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO comments (user_id, flashcard_id, content, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $user_id, $flashcard_id, $content);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Comment added successfully"]);
    } else {
        echo json_encode(["error" => "Failed to add comment"]);
    }

    $stmt->close();

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $flashcard_id = $_GET['flashcard_id'] ;
    $group_id = $_GET['group_id'] ;

    if (!$flashcard_id||!$group_id) {
        echo json_encode(["error" => "Flashcard ID/group_id are required"]);
        exit;
    }

    $sql = " SELECT com.comment_id, com.content, com.created_at, u.user_id, u.firstName, u.lastName, u.pic_path, u.role
         FROM comments com
         JOIN users u ON com.user_id = u.user_id
         WHERE com.flashcard_id = ?
         ORDER BY com.created_at ASC";
      
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $flashcard_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    echo json_encode($comments);
    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>