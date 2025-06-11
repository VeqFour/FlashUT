<?php
header("Content-Type: application/json");
session_start();
include "../../includes/db.php";
include_once "../../partials/functions.php";


if (!isUserLoggedIn()) {
    echo json_encode(["error" => "Not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$flashcard_id = $data['flashcard_id'] ?? null;

if (!$flashcard_id) {
    echo json_encode(["error" => "Flashcard ID missing"]);
    exit();
}

$check = $conn->prepare("SELECT 1 FROM contributions WHERE flashcard_id = ? AND user_id = ? AND type = 'view'");
$check->bind_param("ii", $flashcard_id, $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["success" => true, "message" => "Already viewed"]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO contributions (flashcard_id, user_id, type) VALUES (?, ?, 'view')");
$stmt->bind_param("ii", $flashcard_id, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Insert failed"]);
}