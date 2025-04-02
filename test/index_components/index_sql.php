<?php
// index.php - View and Search Rides

require 'db.php';

// Fetch filter from GET request
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query based on filters

// Only show rides within 24 hours, that are not deleted
$sql = "SELECT * FROM rides WHERE deleted = 0 AND ride_date >= DATE_SUB(NOW(), INTERVAL 1 DAY)"; 
if ($filter === 'looking') {
    $sql .= " AND ride_type = 'looking'";
} elseif ($filter === 'offering') {
    $sql .= " AND ride_type = 'offering'";
}
if (!empty($search)) {
    $sql .= " AND (from_city LIKE ? OR ride_date LIKE ? OR contact LIKE ? OR name LIKE ? OR whatsapp LIKE ?)";
}
$sql .= " ORDER BY ride_date, ride_time";

$stmt = $conn->prepare($sql);
if (!empty($search)) {
    $likeSearch = "%$search%";
    $stmt->bind_param("sssss", $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch);
}
$stmt->execute();
$result = $stmt->get_result();
?>
