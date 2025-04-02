<?php
session_start();
include("connection.php");

if (isset($_SESSION['user_id']) && isset($_SESSION['session_id'])) {
    $user_id = $_SESSION['user_id'];
    $session_id = $_SESSION['session_id'];

    // Update the last_active time for the current session/device
    $stmt = $con->prepare("UPDATE active_players SET last_active = NOW() WHERE user_id = ? AND session_id = ?");
    $stmt->bind_param("is", $user_id, $session_id);
    $stmt->execute();
    $stmt->close();
}
?>
