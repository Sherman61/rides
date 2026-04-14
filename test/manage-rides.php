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
    <style>
        body { background: #eae7dc; color: #1f2937; }
        .page-wrap { max-width: 1100px; margin: 34px auto; }
        .card { border: none; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,.1); }
        .card-title { color: #071d41e7; font-size: 1.1rem; }
        .btn-danger { background-color: #b92d5d; border-color: #b92d5d; }
        .btn-warning { color: #fff; }
        #openNav { font-size: 24px; cursor: pointer; color: #071d41e7; }
    </style>
</head>
<body>
<div class="container page-wrap">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <i class="fa-solid fa-arrow-left" id="openNav" onclick="location.href='auth/index.php'"></i>
        <h1 class="text-center mb-0">My Rides</h1>
        <span></span>
    </div>

    <?php if ($result->num_rows === 0): ?>
        <div class="alert alert-info text-center">You haven't added any rides yet.</div>
    <?php else: ?>
        <div class="row g-3">
            <?php while ($ride = $result->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($ride['ride_type']) === 'looking' ? 'Looking from' : 'Offering from'; ?> <?= htmlspecialchars($ride['from_city']); ?></h5>
                            <p class="mb-1"><strong>Date:</strong> <?= htmlspecialchars($ride['ride_date']); ?></p>
                            <p class="mb-1"><strong>Time:</strong> <?= $ride['ride_time'] ? date('h:i A', strtotime($ride['ride_time'])) : 'No Set Time'; ?></p>
                            <p class="mb-1"><strong>Contact:</strong> <?= htmlspecialchars($ride['contact']); ?></p>
                            <?php if (!empty($ride['memo'])): ?>
                                <p class="mb-2"><strong>Memo:</strong> <?= htmlspecialchars($ride['memo']); ?></p>
                            <?php endif; ?>

                            <div class="form-check mb-2 mt-auto">
                                <input class="form-check-input prevent-toggle" type="checkbox"
                                       data-id="<?= $ride['id'] ?>"
                                       <?= $ride['prevent_delete'] ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    Prevent accidental deletion
                                </label>
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $ride['id'] ?>">Delete</button>
                                <a href="edit.php?id=<?= $ride['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            </div>
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
                    body: `id=${rideId}`
                })
                .then(res => res.json().then(data => ({ ok: res.ok, data })))
                .then(({ ok, data }) => {
                    alert(data.message || (ok ? 'Ride deleted.' : 'Failed to delete ride.'));
                    if (ok) location.reload();
                })
                .catch(() => alert("Error deleting ride."));
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
                body: `id=${rideId}&prevent_delete=${value}`
            })
            .catch(() => alert("Failed to update protection setting."));
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
