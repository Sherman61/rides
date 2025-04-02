<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$ride_id = intval($_POST['ride_id']);
$prevent_delete = isset($_POST['prevent_delete']) ? 1 : 0;

$stmt = $conn->prepare("UPDATE rides SET prevent_delete = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("iii", $prevent_delete, $ride_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => $prevent_delete ? "Ride protection enabled." : "Ride protection disabled."]);
} else {
    echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
