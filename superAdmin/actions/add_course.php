<?php
require_once "../../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseName = trim($_POST['course_name']);
    $departmentId = $_POST['department_id'];
    $image = $_FILES['course_image'];

    $checkQuery = $conn->prepare("SELECT course_id FROM courses WHERE course_name = ? AND department_id = ?");
    $checkQuery->bind_param("si", $courseName, $departmentId);
    $checkQuery->execute();
    $checkQuery->store_result();

    if ($checkQuery->num_rows > 0) {
        header("Location: ../administrator.php?error=Course already exists in this department");
        exit();
    }

    $allowedTypes = ['image/jpeg', 'image/png'];
    if (!in_array($image['type'], $allowedTypes)) {
        header("Location: ../administrator.php?error=Only JPG and PNG files are allowed");
        exit();
    }

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/FlashUT/template/imgCourses/";

    $cleanCourseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($courseName));
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $fileName = $cleanCourseName . "." . $extension;    $targetPath = $uploadDir . $fileName;
    
    $relativePath =$fileName;

    if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
        header("Location: ../administrator.php?error=Failed to upload image.");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO courses (course_name, department_id, image_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $courseName, $departmentId, $relativePath);

    if ($stmt->execute()) {
        header("Location: ../administrator.php?message=Course added successfully");
    } else {
        header("Location: ../administrator.php?error=Database error.");
    }
}
?>