<?php
header("Content-Type: application/json");
session_start();
include_once "../../partials/auth_admin.php";
include_once "../../includes/db.php";


$adminId = $_SESSION['user_id'];
if (!isset($adminId) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["action"]) && $data["action"] === "delete_group" && isset($data["group_id"]) && isset($data["section_id"])) {
        $groupId = intval($data["group_id"]);
        $sectionId = intval($data["section_id"]);

        $checkStmt = $conn->prepare("SELECT * FROM groups WHERE group_id = ? AND section_id = ?");
        $checkStmt->bind_param("ii", $groupId, $sectionId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows === 0) {
            echo json_encode(["success" => false, "message" => "Group not found for this course."]);
            exit;
        }

        $deleteStmt = $conn->prepare("DELETE FROM groups WHERE group_id = ? AND section_id = ?");
        $deleteStmt->bind_param("ii", $groupId, $sectionId);

        if ($deleteStmt->execute()) {
            echo json_encode(["success" => true, "message" => "Group deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to delete group."]);
        }

        exit;
    }

    if (isset($data["action"]) && $data["action"] === "edit_group" && isset($data["group_id"]) && isset($data["section_id"])&& isset($data["new_name"])) {
      $groupId = intval($data["group_id"]);
      $sectionId = intval($data["section_id"]);
      $newName = trim($data["new_name"]);

      if ($newName === "" || strlen($newName) > 255) {
          echo json_encode(["success" => false, "message" => "Invalid group name."]);
          exit;
      }

      $stmt = $conn->prepare("UPDATE groups SET group_name = ? WHERE group_id = ? AND section_id = ?");
      $stmt->bind_param("sii", $newName, $groupId, $sectionId);

      if ($stmt->execute()) {
          echo json_encode(["success" => true]);
      } else {
          echo json_encode(["success" => false, "message" => "Failed to update group."]);
      }
      $stmt->close();
      $conn->close();
      exit;
  }
  if (isset($data["action"]) && $data["action"] === "delete_flashcard" && isset($data["flashcard_id"])) {
      $flashcardId = intval($data["flashcard_id"]);
  
  
      $stmt = $conn->prepare("DELETE FROM flashcards WHERE flashcard_id = ?");
      $stmt->bind_param("i", $flashcardId);
  
      if ($stmt->execute()) {
          echo json_encode(["success" => true]);
      } else {
          echo json_encode(["success" => false, "message" => "Failed to delete flashcard."]);
      }
  
      $stmt->close();
      $conn->close();
      exit;
  }
  
  if (
      isset($data["action"]) && $data["action"] === "add_group" &&
      isset($data["section_id"]) && isset($data["group_name"])
  ) {
      $sectionId = intval($data["section_id"]);
      $groupName = trim($data["group_name"]);
  
      if ($groupName === "" || strlen($groupName) > 255) {
          echo json_encode(["success" => false, "message" => "Invalid group name."]);
          exit;
      }
  
      $checkStmt = $conn->prepare("SELECT group_id FROM groups WHERE section_id = ? AND group_name = ?");
      $checkStmt->bind_param("is", $sectionId, $groupName);
      $checkStmt->execute();
      $checkResult = $checkStmt->get_result();
      if ($checkResult->num_rows > 0) {
          echo json_encode(["success" => false, "message" => "Group name already exists."]);
          exit;
      }
  
      $stmt = $conn->prepare("INSERT INTO groups (group_name, section_id) VALUES (?, ?)");
      $stmt->bind_param("si", $groupName, $sectionId);
  
      if ($stmt->execute()) {
          echo json_encode(["success" => true]);
      } else {
          echo json_encode(["success" => false, "message" => "Failed to create group."]);
      }
  
      $stmt->close();
      $conn->close();
      exit;
  }
  if (
    isset($data['action']) &&
    $data['action'] === 'approve_and_assign_flashcard' &&
    isset($data['flashcard_id']) &&
    isset($data['group_id'])
) {
    $flashcardId = intval($data['flashcard_id']);
    $groupId = intval($data['group_id']);

    mysqli_begin_transaction($conn);

    try {
        $checkFlashcard = $conn->prepare("SELECT flashcard_id FROM flashcards WHERE flashcard_id = ?");
        $checkFlashcard->bind_param("i", $flashcardId);
        $checkFlashcard->execute();
        if ($checkFlashcard->get_result()->num_rows === 0) {
            throw new Exception('Flashcard not found.');
        }

        $checkGroup = $conn->prepare("SELECT group_id FROM groups WHERE group_id = ?");
        $checkGroup->bind_param("i", $groupId);
        $checkGroup->execute();
        if ($checkGroup->get_result()->num_rows === 0) {
            throw new Exception('Group not found.');
        }

        $updateReview = $conn->prepare("UPDATE review SET admin_status = 'approved', reviewed_at = NOW(), admin_id = ? WHERE flashcard_id = ?");
        $updateReview->bind_param("ii", $adminId, $flashcardId);
        if (!$updateReview->execute()) {
            throw new Exception('Failed to update review.');
        }

        $getUser = $conn->prepare("SELECT user_id FROM flashcards WHERE flashcard_id = ?");
        $getUser->bind_param("i", $flashcardId);
        $getUser->execute();
        $getUserResult = $getUser->get_result();
        $userRow = $getUserResult->fetch_assoc();
        $getUser->close();

        if (!$userRow) {
            throw new Exception('Flashcard owner not found.');
        }

        $studentId = $userRow['user_id'];

        $addContribution = $conn->prepare("
            INSERT INTO contributions (user_id, flashcard_id, type) 
            VALUES (?, ?, 'add')
        ");
        $addContribution->bind_param("ii", $studentId, $flashcardId);

        if (!$addContribution->execute()) {
            throw new Exception('Failed to add contribution record.');
        }
        $addContribution->close();

            
        
        $assignGroup = $conn->prepare("UPDATE flashcards SET group_id = ? WHERE flashcard_id = ?");
        $assignGroup->bind_param("ii", $groupId, $flashcardId);
        if (!$assignGroup->execute()) {
            throw new Exception('Failed to assign group.');
        }

        $getUserStmt = $conn->prepare("SELECT user_id FROM flashcards WHERE flashcard_id = ?");
        $getUserStmt->bind_param("i", $flashcardId);
        $getUserStmt->execute();
        $getUserResult = $getUserStmt->get_result();
        $userRow = $getUserResult->fetch_assoc();
        $studentId = $userRow['user_id'] ?? null;
        $getUserStmt->close();

if ($studentId) {
    $addContribution = $conn->prepare("INSERT INTO contributions (user_id, type, flashcard_id) VALUES (?, 'add', ?)");
    $addContribution->bind_param("ii", $studentId, $flashcardId);
    if (!$addContribution->execute()) {
        throw new Exception('Failed to insert contribution.');
    }
    $addContribution->close();
}

        mysqli_commit($conn);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// === Reject Flashcard ===
if (
    isset($data["action"]) &&
    $data["action"] === "reject_flashcard" &&
    isset($data["flashcard_id"]) &&
    isset($data["feedback"])
) {
    $flashcardId = intval($data["flashcard_id"]);
    $feedback = trim($data["feedback"]);

    if (empty($feedback)) {
        echo json_encode(["success" => false, "message" => "Feedback cannot be empty."]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE review SET admin_status = 'rejected', admin_feedback = ?, reviewed_at = NOW(), admin_id = ? WHERE flashcard_id = ?");
    $stmt->bind_param("sii", $feedback, $adminId, $flashcardId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to reject flashcard."]);
    }

    $stmt->close();
    exit;
}
}

echo json_encode(["success" => false, "message" => "Invalid request."]);
exit;