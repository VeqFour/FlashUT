<?php
session_start();
include "../includes/db.php";
include_once "../partials/functions.php";

if (!isUserLoggedIn()) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userId = $_SESSION['user_id'];

if (!isset($_FILES['profilePic']) || $_FILES['profilePic']['error'] !== 0) {
    echo json_encode(["success" => false, "message" => "No file uploaded"]);
    exit;
}

$fileTmpPath = $_FILES['profilePic']['tmp_name'];
$mime = mime_content_type($fileTmpPath);

$allowed = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/gif'  => 'gif',
    'image/webp' => 'webp',
    'image/bmp'  => 'bmp'
];

if (!array_key_exists($mime, $allowed)) {
    echo json_encode(["success" => false, "message" => "Unsupported image type"]);
    exit;
}

switch ($mime) {
    case 'image/jpeg':
        $original = imagecreatefromjpeg($fileTmpPath);
        break;
    case 'image/png':
        $original = imagecreatefrompng($fileTmpPath);
        break;
    case 'image/gif':
        $original = imagecreatefromgif($fileTmpPath);
        break;
    case 'image/webp':
        $original = imagecreatefromwebp($fileTmpPath);
        break;
    case 'image/bmp':
        $original = imagecreatefrombmp($fileTmpPath);
        break;
    default:
        echo json_encode(["success" => false, "message" => "Unsupported image format"]);
        exit;
}

if (!$original) {
    echo json_encode(["success" => false, "message" => "Could not process image"]);
    exit;
}

$width = imagesx($original);
$height = imagesy($original);
$side = min($width, $height);
$dstSize =400;

$srcX = ($width - $side) / 2;
$srcY = ($height - $side) /2;

$cropped = imagecreatetruecolor($dstSize, $dstSize);
imagecopyresampled($cropped, $original, 0, 0, $srcX, $srcY, $dstSize, $dstSize, $side, $side);
$filename = "profile_$userId.jpg";
$path = "template/imgProfile/$filename";
$fullPath = __DIR__ . "/../$path";

imagejpeg($cropped, $fullPath, 90);
imagedestroy($original);
imagedestroy($cropped);

$conn->query("UPDATE users SET pic_path = '$filename' WHERE user_id = $userId");

echo json_encode(["success" => true, "path" => $filename]);
?>