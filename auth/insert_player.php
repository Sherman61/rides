<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("insert_active_player.php");

// Check if the user is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
$session_id = $_SESSION['session_id'];
    // Insert the user into the active_players table
    insertActivePlayer($user_id, $username, $session_id);
} else {
    echo "User not logged in or session variables missing.";
}
?>
  