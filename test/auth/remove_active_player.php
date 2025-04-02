<?php
include("connection.php");

function removeActivePlayer($user_id, $session_id) {
    global $con;

    // Check how many sessions the user has
    $stmt = $con->prepare("SELECT COUNT(*) FROM active_players WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($session_count);
    $stmt->fetch();
    $stmt->close();

    if ($session_count > 1) {
        // If there are multiple sessions, update the specific session entry
        // Set session_id to NULL and keep the last_active time intact
        $stmt = $con->prepare("UPDATE active_players SET session_id = NULL WHERE user_id = ? AND session_id = ?");
        $stmt->bind_param("is", $user_id, $session_id);
    } else {
        // If it's the last session, update the session_id to NULL but retain the row
        $stmt = $con->prepare("UPDATE active_players SET session_id = NULL, last_active = NOW() WHERE user_id = ? AND session_id = ?");
        $stmt->bind_param("is", $user_id, $session_id);
    }

    $stmt->execute();
    $stmt->close();
}
?>
