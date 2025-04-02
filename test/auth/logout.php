<?php
session_start();
include("remove_player.php");

if (isset($_SESSION['user_id']) && isset($_SESSION['session_id'])) {
    $user_id = $_SESSION['user_id'];
    $session_id = $_SESSION['session_id'];

    // Remove the active player session
    removePlayer($user_id, $session_id);
}

// Unset session variables
unset($_SESSION['user_id']);
unset($_SESSION['session_id']);
unset($_SESSION['username']);

// Redirect to the login page
header("Location: login.php");
exit;
?>
