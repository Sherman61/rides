<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Easily coordinate rides for our weekly jam session. Whether you're looking for a ride or offering one, connect with friends and keep the music going!" />
    <title>design 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #5D4037;
            color: #FFD700;
        }
        .container {
            background: #000000;
            padding: 20px;
            border-radius: 10px;
        }
        .card {
            background: #B0BEC5;
            color: #000000;
        }
        .btn-primary {
            background-color: #FFD700;
            border: none;
        }
        .btn-primary:hover {
            background-color: #FFAB91;
        }
        h1, h2 {
            color: #FFD700;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="add.php" class="btn btn-primary">Add Ride <i class="fa fa-plus"></i></a>
            <h1 class="text-center flex-grow-1">Available Rides</h1>
        </div>
        <div class="mb-3">
            <select id="filter-select" class="form-select">
                <option value="">All Rides</option>
                <option value="looking">Looking for a Ride</option>
                <option value="offering">Offering a Ride</option>
            </select>
        </div>
        <div class="mb-3">
            <input type="text" id="search-bar" class="form-control" placeholder="Search...">
        </div>
        <div id="rides-list">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Looking from Boro Park</h5>
                    <p><strong>Name:</strong> John Doe</p>
                    <p><strong>Date:</strong> 2025-02-03</p>
                    <p><strong>Time:</strong> 5:30 PM</p>
                    <p><strong>Contact:</strong> <a href="tel:+123456789">+123456789</a></p>
                    <p><strong>WhatsApp:</strong> <a href="https://wa.me/+123456789" target="_blank">Chat on WhatsApp</a></p>
                    <a href="edit.php" class="btn btn-warning">Edit</a>
                    <a href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Offering a Ride from monsey</h5>
                    <p><strong>Name:</strong> Jane Smith</p>
                    <p><strong>Date:</strong> 2025-02-04</p>
                    <p><strong>Time:</strong> 8:00 AM</p>
                    <p><strong>Contact:</strong> <a href="tel:+987654321">+987654321</a></p>
                    <p><strong>WhatsApp:</strong> <a href="https://wa.me/+987654321" target="_blank">Chat on WhatsApp</a></p>
                    <a href="edit.php" class="btn btn-warning">Edit</a>
                    <a href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
