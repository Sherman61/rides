<?php
// edit.php - Edit Ride Details

require 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the ride details
    $stmt = $conn->prepare("SELECT * FROM rides WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ride = $result->fetch_assoc();

    if (!$ride) {
        echo "<script>alert('Invalid Ride ID. Redirecting to home...'); window.location.href = 'index.php';</script>";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $ride_type = trim($_POST['ride_type']);
        $from_city = trim($_POST['from_city']);
        $ride_date = trim($_POST['ride_date']);
        $ride_time = isset($_POST['whenever']) ? null : trim($_POST['ride_time']);
        $contact = trim($_POST['contact']);
        $whatsapp = !empty($_POST['whatsapp']) ? trim($_POST['whatsapp']) : null;
        $memo = !empty($_POST['memo']) ? substr(trim($_POST['memo']), 0, 100) : null;
    
        $update_stmt = $conn->prepare("UPDATE rides SET name = ?, ride_type = ?, from_city = ?, ride_date = ?, ride_time = ?, contact = ?, whatsapp = ?, memo = ? WHERE id = ?");
        $update_stmt->bind_param("ssssssssi", $name, $ride_type, $from_city, $ride_date, $ride_time, $contact, $whatsapp, $memo, $id);

        if ($update_stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error updating ride: " . $update_stmt->error . "</div>";
        }
    }
} else {
    echo "<div class='alert alert-danger'>Invalid Ride ID.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ride</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="add.css">
</head>
<body>
    <div class="container mt-5"> 
        <i class="fa-solid fa-arrow-left" id="openNav" onclick="location.href='index.php'"></i>
        <h1 class="text-center mb-4">Edit Ride</h1>
        <form method="POST" class="border p-4 rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($ride['name']); ?>" minlength="2" maxlength="50" required>
            </div>

            <div class="mb-3">
                <label for="ride_type" class="form-label">Ride Type</label>
                <select id="ride_type" name="ride_type" class="form-select" required>
                    <option value="looking" <?php echo $ride['ride_type'] === 'looking' ? 'selected' : ''; ?>>Looking for a ride</option>
                    <option value="offering" <?php echo $ride['ride_type'] === 'offering' ? 'selected' : ''; ?>>Offering a ride</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="from_city" class="form-label">From (City)</label>
                <input type="text" id="from_city" name="from_city" class="form-control" value="<?php echo htmlspecialchars($ride['from_city']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="ride_date" class="form-label">Date</label>
                <input type="date" id="ride_date" name="ride_date" class="form-control" value="<?php echo htmlspecialchars($ride['ride_date']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="ride_time" class="form-label">Time</label>
                <input type="time" id="ride_time" name="ride_time" class="form-control" value="<?php echo htmlspecialchars($ride['ride_time'] ?: ''); ?>">
                <div class="form-check mt-2">
                    <input type="checkbox" id="whenever" name="whenever" class="form-check-input" <?php echo is_null($ride['ride_time']) ? 'checked' : ''; ?>>
                    <label for="whenever" class="form-check-label">Whenever/Flexible</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="contact" class="form-label">Contact</label>
                <input type="text" id="contact" name="contact" class="form-control"
                       pattern="^\+?[0-9()\s-]{10,25}$"
                       value="<?php echo htmlspecialchars($ride['contact']); ?>" required>
                <small class="text-danger d-none" id="contact-error">Invalid format! Use 10-25 digits, +, (), -</small>
            </div>

            <div class="mb-3">
                <label for="whatsapp" class="form-label">WhatsApp (optional)</label>
                <input type="text" id="whatsapp" name="whatsapp" class="form-control"
                       pattern="^\d{10,11}$"
                       value="<?php echo htmlspecialchars($ride['whatsapp'] ?? ''); ?>">
                <small class="text-danger d-none" id="whatsapp-error">Only numbers allowed (10-11 digits)</small>
            </div>

            <div class="mb-3">
                <label for="memo" class="form-label">Memo (optional)</label>
                <textarea id="memo" name="memo" class="form-control" maxlength="101" placeholder="Add any notes or details..."><?php echo htmlspecialchars($ride['memo'] ?? ''); ?></textarea>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
    <?php include_once "footer.php" ?>
    <script src="ride.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>
