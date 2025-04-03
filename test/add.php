<?php
// add.php - Add New Ride
require 'db.php';
session_start(); // Needed to check if user is logged in

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $ride_type = $_POST['ride_type'];
    $from_city = $_POST['from_city'];
    $ride_date = $_POST['ride_date'];
    $ride_time = isset($_POST['whenever']) ? null : $_POST['ride_time'];
    $contact = $_POST['contact'];
    $whatsapp = !empty($_POST['whatsapp']) ? $_POST['whatsapp'] : "";
    $memo = !empty($_POST['memo']) ? substr(trim($_POST['memo']), 0, 100) : "";

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if ($user_id) {
        $stmt = $conn->prepare("INSERT INTO rides (name, ride_type, from_city, ride_date, ride_time, contact, whatsapp, memo, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssi", $name, $ride_type, $from_city, $ride_date, $ride_time, $contact, $whatsapp, $memo, $user_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO rides (name, ride_type, from_city, ride_date, ride_time, contact, whatsapp, memo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $ride_type, $from_city, $ride_date, $ride_time, $contact, $whatsapp, $memo);
    }

    if ($stmt->execute()) {
        if (!$user_id) {
            $_SESSION['pending_ride_id'] = $conn->insert_id;
        }
        
        $stmt->close();
        $conn->close();

        // If the user is logged in, just redirect to index
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }

        // Show login suggestion if user is not logged in
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Ride Added</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body>
        
        <div class='container mt-5 text-center'>
            <div class='alert alert-success'>
                Ride successfully added!
            </div>
            <div class='alert alert-info'>
                <p><strong>Want to manage your ride later?</strong></p>
                <p>
                    <a href='auth/login.php' class='btn btn-primary'>Login</a> to unlock features like ride chats, ride history, and editing/deleting your rides.
                </p>
                <p>Redirecting to home in <span id='countdown'>10</span> seconds...</p>
            </div>
        </div>
        <script>
            let seconds = 10;
            const countdown = document.getElementById('countdown');
            const interval = setInterval(() => {
                seconds--;
                countdown.textContent = seconds;
                if (seconds <= 0) {
                    clearInterval(interval);
                    window.location.href = 'index.php';
                }
            }, 1000);
        </script>
        </body>
        </html>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Easily add your ride details to our carpooling system. Whether you're offering a ride or looking for one, submit your information in seconds and connect with others for a smooth journey.">
    <title>Add Ride</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="add.css">
</head>
<body>

<div class="container mt-5">
    <i class="fa-solid fa-arrow-left" id="openNav" onclick="location.href='index.php'"></i>
    <h1 class="text-center mb-4">Add New Ride</h1>
    <form method="POST" class="border p-4 rounded shadow-sm bg-light">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" minlength="2" maxlength="60" required>
        </div>

        <div class="mb-3">
            <label for="ride_type" class="form-label">Ride Type</label>
            <select id="ride_type" name="ride_type" class="form-select" required>
                <option value="" disabled selected>Select a ride type</option>
                <option value="looking">Looking for a Ride</option>
                <option value="offering">Offering a Ride</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="from_city" class="form-label">From (City)</label>
            <input type="text" id="from_city" name="from_city" class="form-control" minlength="2" required>
        </div>

        <div class="mb-3">
            <label for="ride_date" class="form-label">Date</label>
            <input type="date" id="ride_date" name="ride_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <div class="mb-3">
            <label for="ride_time" class="form-label">Time</label>
            <input type="time" id="ride_time" name="ride_time" class="form-control">
            <div class="form-check mt-2">
                <input type="checkbox" id="whenever" name="whenever" class="form-check-input">
                <label for="whenever" class="form-check-label">Whenever/Flexible</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" id="contact" name="contact" class="form-control"
                   pattern="^\+?[0-9()\s-]{10,25}$" required>
            <small class="text-danger d-none" id="contact-error">Invalid format! Use 10-25 digits, +, (), -</small>
        </div>

        <div class="mb-3">
            <label for="whatsapp" class="form-label">WhatsApp (optional)</label>
            <input type="text" id="whatsapp" name="whatsapp" class="form-control"
                   pattern="^\d{10,11}$" placeholder="Enter WhatsApp number">
            <small class="text-danger d-none" id="whatsapp-error">Only numbers allowed (10-11 digits)</small>
        </div>

        <div class="mb-3">
            <label for="memo" class="form-label">Memo (optional)</label>
            <textarea id="memo" name="memo" class="form-control" maxlength="100" rows="3" placeholder="Optional note or detail (max 100 characters)"></textarea>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Add Ride</button>
        </div>
    </form>
</div>

<?php include_once "footer.php" ?>
<script src="ride.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
