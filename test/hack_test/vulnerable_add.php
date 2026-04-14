<?php
// ❌ This is deliberately vulnerable to SQL Injection

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact = $_POST['contact'];

    // This is the DANGEROUS line (no prepared statement!)
    $sql = "INSERT INTO rides (contact) VALUES ('$contact')";

    if ($conn->multi_query($sql)) {
        echo "<div style='color: green;'>Ride added successfully.</div>";
    } else {
        echo "<div style='color: red;'>Error: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>
