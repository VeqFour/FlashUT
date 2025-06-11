<?php
header("Content-Type: application/json");
session_start();
include_once "../../partials/auth_admin.php";
include "../../includes/db.php";


if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
      echo json_encode(["success" => false, "message" => "Not logged in"]);
      exit;
  }

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $password = trim($input['password'] ?? '');

    if (strlen($password) < 6) {
        echo json_encode(["success" => false, "message" => "Password must be at least 6 characters."]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $hashedPassword, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Password updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating password."]);
    }
    exit;
}

$stmt = $conn->prepare("SELECT firstName,lastName, email, academicID,pic_path FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

echo json_encode([
    "success" => true,
    "user" => $userData
]);