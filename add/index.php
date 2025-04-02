

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-61ZF3YJ4R0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-61ZF3YJ4R0');
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Easily add your ride details to our carpooling system. Whether you're offering a ride or looking for one, submit your information in seconds and connect with others for a smooth journey.">

    <title>Add Ride</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
<link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
    <i class="fa-solid fa-arrow-left" id="openNav" onclick="location.href='index.php'"></i>
        <h1 class="text-center mb-4" id="header-text">Add New Ride</h1>
        
  <!-- Color Customization Controls -->
  <div class="mt-4 p-3 bg-light rounded">
            <h3>Customize Colors</h3>
            <label>Body Background: <input type="color" id="body-bg" value="#eae7dc"></label>
            <label>Container Background: <input type="color" id="container-bg" value="#ffffff"></label>
            <label>Add Button: <input type="color" id="add-btn-color" value="#74a7ff"></label>
            <label>Error Message Background: <input type="color" id="error-bg" value="#ffdddd"></label>
            <label>Error Message Text: <input type="color" id="error-text" value="#a94442"></label>
            <button id="copy-colors" class="btn btn-secondary mt-3">Copy Colors</button>
        </div>
        <form method="POST" class="border p-4 rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" minlength="2" maxlength="60" placeholder="Enter your name" required>
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
                <input type="text" id="from_city" name="from_city" class="form-control" placeholder="Enter city" minlength="2" required>
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
           pattern="^\+?[0-9()\s-]{10,25}$"
           value="<?php echo htmlspecialchars($ride['contact']); ?>"
           placeholder="Enter phone number" required>
    <small class="text-danger d-none" id="contact-error">Invalid format! Use 10-20 digits, +, (), -</small>
</div> 

<div class="mb-3">
    <label for="whatsapp" class="form-label">WhatsApp (optional)</label>
    <input type="text" id="whatsapp" name="whatsapp" class="form-control"
           pattern="^\d{10,11}$"
           value="<?php echo htmlspecialchars($ride['whatsapp'] ?? ''); ?>"
           placeholder="Enter WhatsApp number">
    <small class="text-danger d-none" id="whatsapp-error">Only numbers allowed (10-11 digits)</small>
</div>


            <div class="d-grid">
                <button type="submit" class="btn btn-primary" id="add-btn">Add Ride</button>
            </div>
        </form>
    </div>
    <?php include_once "footer.php" ?>
    <script>
        document.querySelector('#body-bg').addEventListener('input', (e) => {
            document.body.style.backgroundColor = e.target.value;
        });
        document.querySelector('#container-bg').addEventListener('input', (e) => {
            document.querySelector('.container').style.backgroundColor = e.target.value;
        });
        document.querySelector('#add-btn-color').addEventListener('input', (e) => {
            document.querySelector('#add-btn').style.backgroundColor = e.target.value;
        });
        document.querySelector('#error-bg').addEventListener('input', (e) => {
            document.querySelector('.alert-danger').style.backgroundColor = e.target.value;
        });
        document.querySelector('#error-text').addEventListener('input', (e) => {
            document.querySelector('.alert-danger').style.color = e.target.value;
        });
        document.querySelector('#copy-colors').addEventListener('click', () => {
            const colors = {
                bodyBg: document.querySelector('#body-bg').value,
                containerBg: document.querySelector('#container-bg').value,
                addBtn: document.querySelector('#add-btn-color').value,
                errorBg: document.querySelector('#error-bg').value,
                errorText: document.querySelector('#error-text').value
            };
            navigator.clipboard.writeText(JSON.stringify(colors, null, 2)).then(() => {
                alert('Colors copied to clipboard!');
            }).catch(err => console.error('Failed to copy:', err));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
