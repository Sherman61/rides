<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Easily coordinate rides for our weekly jam session. Whether you're looking for a ride or offering one, connect with friends and keep the music going!" />
    <title>Available Rides</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Option 3: Modern Minimalist Design */
        body {
            background-color: #eae7dc;
            color: #5d4037;
            font-family: Arial, sans-serif;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            background: #fff8e1;
            color: #5d4037;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #8f3f11;
            border: none;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #eb9100;
        }
        .btn-warning {
            background-color: #eb9100;
            border: none;
            color: white;
        }
        .btn-warning:hover {
            background-color: #d67600;
        }
        .btn-danger {
            background-color: #cf3636;
            border: none;
            color: white;
        }
        .btn-danger:hover {
            background-color: #b52c2c;
        }
        h1, h2 {
            color: #5d4037;
        }
        .color-picker {
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="add.php" class="btn btn-primary" id="add-btn">Add Ride <i class="fa fa-plus"></i></a>
            <h1 class="text-center flex-grow-1" id="header-text">Available Rides</h1>
        </div>
        <div id="rides-list">
            <div class="card mb-3" id="ride-card">
                <div class="card-body">
                    <h5 class="card-title">Looking from New York</h5>
                    <p><strong>Name:</strong> John Doe</p>
                    <p><strong>Date:</strong> 2025-02-03</p>
                    <p><strong>Time:</strong> 5:30 PM</p>
                    <p><strong>Contact:</strong> <a href="tel:+123456789">+123456789</a></p>
                    <p><strong>WhatsApp:</strong> <a href="https://wa.me/+123456789" target="_blank">Chat on WhatsApp</a></p>
                    <a href="edit.php" class="btn btn-warning">Edit</a>
                    <a href="#" class="btn btn-danger">Delete</a>
                </div> 
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
