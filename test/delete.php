<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid ride ID."]);
        exit;
    }

    $query = "SELECT user_id, prevent_delete FROM rides WHERE id = ?";
    $check_stmt = $conn->prepare($query);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $ride = $result->fetch_assoc();
    $check_stmt->close();

    if (!$ride) {
        echo json_encode(["success" => false, "message" => "Ride not found."]);
        exit;
    }

    // If prevent_delete is true, only owner can delete
    if ($ride['prevent_delete']) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $ride['user_id']) {
            echo json_encode(["success" => false, "message" => "This ride is protected. Only the owner can delete it."]);
            exit;
        }
    }

    $stmt = $conn->prepare("UPDATE rides SET deleted = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Ride deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}

$conn->close();
