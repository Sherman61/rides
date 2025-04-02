<?php
// delete.php - Delete Ride from MySQL

require 'db.php';

// Ensure the request is a POST request and contains the 'id' parameter
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Validate the ID (ensure it's a positive integer)
    if ($id <= 0) {
        http_response_code(400); // Bad request
        echo json_encode(["message" => "Invalid ride ID."]);
        exit;
    }

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM rides WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        http_response_code(200); // Success response
        echo json_encode(["message" => "Ride deleted successfully!"]);
    } else {
        http_response_code(500); // Error response
        echo json_encode(["message" => "Error deleting ride: " . $stmt->error]);
    }

    $stmt->close();
} else {
    http_response_code(400); // Bad request
    echo json_encode(["message" => "Invalid request."]);
}

$conn->close();
?>