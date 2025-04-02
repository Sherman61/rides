<?php
include("connection.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function insertActivePlayer($user_id, $username, $session_id) {
    global $con;

    // Check if the session already exists in the active_players table
    $stmt = $con->prepare("SELECT id FROM active_players WHERE user_id = ? AND session_id = ?");
    $stmt->bind_param("is", $user_id, $session_id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Session exists, update the last_active time 
        $stmt->close();
        $update_stmt = $con->prepare("UPDATE active_players SET last_active = NOW() WHERE user_id = ? AND session_id = ?");
        $update_stmt->bind_param("is", $user_id, $session_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Session doesn't exist, insert a new record
        $stmt->close();
        $insert_stmt = $con->prepare("INSERT INTO active_players (user_id, username, session_id, start_time, last_active) VALUES (?, ?, ?, NOW(), NOW())");
        if ($insert_stmt) {
            $insert_stmt->bind_param("iss", $user_id, $username, $session_id);
            $insert_stmt->execute();
            $insert_stmt->close();
        } else {
            echo "Error: " . $con->error;
        }
    }
}
?>
