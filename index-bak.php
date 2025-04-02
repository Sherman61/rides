<?php
// index.php - View and Search Rides

require 'db.php';

// Fetch filter from GET request
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query based on filters
$sql = "SELECT * FROM rides WHERE ride_date >= DATE_SUB(NOW(), INTERVAL 1 DAY)"; // Only show rides within 24 hours
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

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-61ZF3YJ4R0"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-61ZF3YJ4R0');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Easily coordinate rides for our weekly jam session. Whether you're looking for a ride or offering one, connect with friends and keep the music going!" />

    <title>Available Rides</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="add.php" id="plus" class="btn border">
                Add Ride <i class="fa fa-plus" aria-hidden="true"></i>
            </a>
            <h1 class="text-center flex-grow-1">Available Rides</h1>
        </div>

        <!-- Filter Dropdown -->
        <div class="mb-3">
            <select id="filter-select" class="form-select">
                <option value="" <?php echo $filter === '' ? 'selected' : ''; ?>>All Rides</option>
                <option value="looking" <?php echo $filter === 'looking' ? 'selected' : ''; ?>>Looking for a Ride</option>
                <option value="offering" <?php echo $filter === 'offering' ? 'selected' : ''; ?>>Offering a Ride</option>
            </select>
        </div>

        <!-- Search Input -->
        <div class="mb-3">
            <input type="text" id="search-bar" class="form-control" placeholder="Search..."
                value="<?php echo htmlspecialchars($search); ?>">
        </div>

        <!-- Add Ride Button -->
        <div id="looking-rides">
            <h2>Looking for a Ride</h2>
            <div class="row">
                <?php
                $hasLookingRides = false;
                $matchingLookingRides = false;
                $result->data_seek(0);
                while ($row = $result->fetch_assoc()): ?>
                    <?php if ($row['ride_type'] === 'looking'): ?>
                        <?php $hasLookingRides = true; ?>
                        <?php if (empty($search) || stripos($row['from_city'], needle: $search) !== false || stripos($row['contact'], $search) !== false): ?>
                            <?php $matchingLookingRides = true; ?>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">

                                        <h5 class="card-title" style="margin-bottom:20px">Looking from
                                            <?php echo htmlspecialchars($row['from_city']); ?>
                                        </h5>
                                        <p class="card-text"><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?>
                                        </p>
                                        <p class="card-text"><strong><i class="fa-regular fa-calendar"
                                                    aria-hidden="true"></i></strong>
                                            <?php echo htmlspecialchars($row['ride_date']); ?></p>
                                        <p class="card-text"><strong><i class="fa fa-clock" aria-hidden="true"></i></strong>
                                            <?php echo $row['ride_time'] ? date('h:i A', strtotime($row['ride_time'])) : 'No Set Time'; ?>
                                        </p>

                                        <p class="card-text">
                                            <strong><i class="fa fa-phone" aria-hidden="true"
                                                    onclick="location.href='tel:<?php echo htmlspecialchars($row['contact']); ?>'"></i>
                                            </strong>
                                            <a href="tel:<?php echo htmlspecialchars($row['contact']); ?>" class="underline">

                                                <?php echo htmlspecialchars($row['contact']); ?>

                                            </a>
                                        </p>


                                        <?php if (!empty($row['whatsapp'])): ?>
                                            <p class="card-text"><strong> <i class="fa-brands fa-whatsapp text-success"
                                                        onclick="contactWhatsApp('<?php echo $row['whatsapp']; ?>')"></i></strong> <a
                                                    onclick="contactWhatsApp('<?php echo $row['whatsapp']; ?>')"
                                                    href="javascript:void(0);">
                                                    <?php echo htmlspecialchars($row['whatsapp']); ?>
                                                </a></p>
                                        <?php endif; ?>

                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                        <a href="#" class="btn btn-danger"
                                            onclick="confirmDelete(event, <?php echo $row['id']; ?>)">Delete</a>


                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
                <?php if (!$hasLookingRides): ?>
                    <div class="col-md-4">
                        <p class="text-center card">No one is looking for a ride yet.</p>
                    </div>
                <?php elseif (!$matchingLookingRides): ?>
                    <div class="col-md-4">
                        <p class="text-center">No matching results for Looking for a Ride.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Offering a Ride -->
        <div id="offering-rides">
            <h2>Offering a Ride</h2>
            <div class="row">
                <?php
                $hasOfferingRides = false;
                $matchingOfferingRides = false;
                $result->data_seek(0);
                while ($row = $result->fetch_assoc()): ?>
                    <?php if ($row['ride_type'] === 'offering'): ?>
                        <?php $hasOfferingRides = true; ?>
                        <?php if (empty($search) || stripos($row['from_city'], $search) !== false || stripos($row['contact'], $search) !== false): ?>
                            <?php $matchingOfferingRides = true; ?>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title" style="margin-bottom:20px">Offering from
                                            <?php echo htmlspecialchars($row['from_city']); ?>
                                        </h5>
                                        <p class="card-text"><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?>
                                        </p>
                                        <p class="card-text"><strong><i class="fa-regular fa-calendar"
                                                    aria-hidden="true"></i></strong>
                                            <?php echo htmlspecialchars($row['ride_date']); ?></p>
                                        <p class="card-text"><strong><i class="fa fa-clock" aria-hidden="true"></i></strong>
                                            <?php echo $row['ride_time'] ? date('h:i A', strtotime($row['ride_time'])) : 'No Set Time'; ?>
                                        </p>

                                        <p class="card-text">
                                            <strong><i class="fa fa-phone" aria-hidden="true"
                                                    onclick="location.href='tel:<?php echo htmlspecialchars($row['contact']); ?>'"></i>
                                            </strong>
                                            <a href="tel:<?php echo htmlspecialchars($row['contact']); ?>" class="underline">

                                                <?php echo htmlspecialchars($row['contact']); ?>

                                            </a>
                                        </p>
                                        <?php if (!empty($row['whatsapp'])): ?>
                                            <p class="card-text"><strong> <i class="fa-brands fa-whatsapp text-success"
                                                        onclick="contactWhatsApp('<?php echo $row['whatsapp']; ?>')"></i></strong> <a
                                                    class="underline" onclick="contactWhatsApp('<?php echo $row['whatsapp']; ?>')">
                                                    <?php echo htmlspecialchars($row['whatsapp']); ?>
                                                </a></p>

                                        <?php endif; ?>


                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                        <a href="#" class="btn btn-danger"
                                            onclick="confirmDelete(event, <?php echo $row['id']; ?>)">Delete</a>


                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
                <?php if (!$hasOfferingRides): ?>
                    <div class="col-md-4">
                        <p class="text-center card">No rides offered yet.</p>
                    </div>
                <?php elseif (!$matchingOfferingRides): ?>

                    <p class="text-center card">No matching results for Offering a Ride.</p>

                <?php endif; ?>
            </div>
        </div>

        <!-- No Matching Results -->
        <?php if (!$matchingLookingRides && !$matchingOfferingRides): ?>
            <p class="text-center">No matching results for your search.</p>
        <?php endif; ?>
    </div>

    <p id="no-results" class="text-center" style="display: none;">No matching results for your search.</p>


    <?php include_once "footer.php" ?>
    <script>

        function contactWhatsApp(number) {
            window.open(`https://wa.me/${number}`, '_blank');
        }
        function contactDev() {
            window.open(`https://wa.me/8452441202`, '_blank');
        }
        function confirmDelete(event, id) {
            event.preventDefault(); // Prevent the default link behavior

            if (confirm("Are you sure you want to delete this ride?")) {
                fetch("delete.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `id=${id}`,
                })
                    .then(response => {
                        if (response.ok) {
                            return response.json(); // Parse the JSON response
                        } else {
                            throw new Error("Failed to delete ride.");
                        }
                    })
                    .then(data => {
                        alert(data.message); // Show success message
                        location.reload(); // Reload the page to reflect changes
                    })
                    .catch(error => {
                        alert(error.message); // Show error message
                    });
            }
        }

        function contactWhatsApp(number) {
            window.open(`https://wa.me/${number}`, '_blank');
        }

        document.addEventListener("DOMContentLoaded", function () {
            const searchBar = document.getElementById("search-bar");
            const filterSelect = document.getElementById("filter-select");
            const lookingRidesDiv = document.getElementById("looking-rides");
            const offeringRidesDiv = document.getElementById("offering-rides");
            const noResultsMessage = document.getElementById("no-results");

            // Load stored values
            // filterSelect.value = localStorage.getItem("rideFilter") || "";
            // searchBar.value = localStorage.getItem("searchQuery") || "";
            filterSelect.value = "";
            searchBar.value = "";
            function updateRideDisplay() {
                lookingRidesDiv.style.display = filterSelect.value === "offering" ? "none" : "block";
                offeringRidesDiv.style.display = filterSelect.value === "looking" ? "none" : "block";
            }

            filterSelect.addEventListener("change", function () {
                localStorage.setItem("rideFilter", this.value);
                updateRideDisplay();
                applyFilters();
            });

            searchBar.addEventListener("input", function () {
                const searchValue = this.value.trim();
                if (searchValue.length >= 2 || searchValue.length === 0) {
                    localStorage.setItem("searchQuery", searchValue);
                    applyFilters();
                }
            });

            function applyFilters() {
                const search = searchBar.value.toLowerCase();
                const filter = filterSelect.value.toLowerCase();
                let hasResults = false;

                document.querySelectorAll(".card").forEach(card => {
                    const details = card.textContent.toLowerCase();
                    const type = card.querySelector(".card-title").textContent.toLowerCase();

                    const matchesFilter = filter === "" || type.includes(filter);
                    const matchesSearch = search.length < 2 || details.includes(search);

                    if (matchesFilter && matchesSearch) {
                        card.closest(".col-md-4").style.display = "block";
                        hasResults = true;
                    } else {
                        card.closest(".col-md-4").style.display = "none";
                    }
                });

                noResultsMessage.style.display = (search.length >= 2 && !hasResults) ? "block" : "none";
            }

            updateRideDisplay();
            applyFilters();
        });
    </script>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>