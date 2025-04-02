<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM rides WHERE user_id = ? AND deleted = 0 ORDER BY ride_date, ride_time");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage My Rides</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<i class="fa-solid fa-arrow-left" id="openNav" onclick="location.href='auth/index.php'"></i>
    <h1 class="text-center mb-4">My Rides</h1>

    <?php if ($result->num_rows === 0): ?>
        <div class="alert alert-info text-center">You haven't added any rides yet.</div>
    <?php else: ?>
        <div class="row">
            <?php while ($ride = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($ride['ride_type']) === 'looking' ? 'Looking from' : 'Offering from'; ?> <?= htmlspecialchars($ride['from_city']); ?></h5>
                            <p><strong>Date:</strong> <?= htmlspecialchars($ride['ride_date']); ?></p>
                            <p><strong>Time:</strong> <?= $ride['ride_time'] ? date('h:i A', strtotime($ride['ride_time'])) : 'No Set Time'; ?></p>
                            <p><strong>Contact:</strong> <?= htmlspecialchars($ride['contact']); ?></p>
                            <?php if (!empty($ride['memo'])): ?>
                                <p><strong>Memo:</strong> <?= htmlspecialchars($ride['memo']); ?></p>
                            <?php endif; ?>

                            <div class="form-check mb-2">
                                <input class="form-check-input prevent-toggle" type="checkbox"
                                       data-id="<?= $ride['id'] ?>"
                                       <?= $ride['prevent_delete'] ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    Prevent accidental deletion
                                </label>
                            </div>

                            <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $ride['id'] ?>">Delete</button>
                            <a href="edit.php?id=<?= $ride['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', () => {
            const rideId = button.dataset.id;
            if (confirm("Are you sure you want to delete this ride?")) {
                fetch('delete.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `ride_id=${rideId}`
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (res.ok) location.reload();
                })
                .catch(err => alert("Error deleting ride."));
            }
        });
    });

    document.querySelectorAll('.prevent-toggle').forEach(toggle => {
        toggle.addEventListener('change', () => {
            const rideId = toggle.dataset.id;
            const value = toggle.checked ? 1 : 0;

            fetch('toggle_protect.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `ride_id=${rideId}&prevent_delete=${value}`
            })
            .then(res => res.text())
            .then(text => console.log("Toggle updated:", text))
            .catch(err => alert("Failed to update protection setting."));
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
