<?php
header("Content-Type: application/json");
session_start();
include "../../includes/db.php";
include_once "../../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$group_id = intval($data["group_id"]);
$user_id = $_SESSION["user_id"];

$check = $conn->prepare("SELECT * FROM favorite_groups WHERE user_id = ? AND group_id = ?");
$check->bind_param("ii", $user_id, $group_id);
$check->execute();
$result = $check->get_result();




if ($result->num_rows > 0) {
    $delete = $conn->prepare("DELETE FROM favorite_groups WHERE user_id = ? AND group_id = ?");
    $delete->bind_param("ii", $user_id, $group_id);
    $delete->execute();

    echo json_encode(["success" => true, "favorited" => false]);
} else {
    $insert = $conn->prepare("INSERT INTO favorite_groups (user_id, group_id) VALUES (?, ?)");
    $insert->bind_param("ii", $user_id, $group_id);
    $insert->execute();

    echo json_encode(["success" => true, "favorited" => true]);
}
?>