<?php
include 'index_components/error-handler.php';

// index.php - View and Search Rides

require 'db.php';

// Fetch filter from GET request
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query based on filters
$sql = "SELECT * FROM rides WHERE ride_date < DATE_SUB(NOW(), INTERVAL 1 DAY)";

 // Only show rides not in the past 24 hours
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


include 'index_components/header.php';
include 'index_components/nav-bar.php';
// Filter Dropdown plus some more?
include_once 'index_components/filter-dropdown.php';
include_once 'index_components/search-bar.php';
echo "this shows only old rides for analytic purposes";
include 'index_components/ride-list.php';
<div class="space"></div>
include_once "footer.php" ;

?>

<script src="index_components/index.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>