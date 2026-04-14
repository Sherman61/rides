<?php
session_start();

include("connection.php");
include("functions.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if($_SERVER['REQUEST_METHOD'] == "POST")
{ 
    // Something was posted
    $username = trim(strtolower($_POST['username'])); // Convert to lowercase and trim spaces
    $password = $_POST['password'];
    $full_name = trim($_POST['full_name']); // Trim spaces
    $agree = isset($_POST['agree']);

    if(!empty($username) && !empty($password) && !empty($full_name) && $agree)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username already exists
        $stmt = $con->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            // Username already exists
            $error = "Error: This username is already registered. Please try logging in.";
        } else {
            // Save to database
            $stmt = $con->prepare("INSERT INTO users (username, password_hash, full_name, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("sss", $username, $password, $full_name);
            $stmt->execute();
            $stmt->close();

            header("Location: login.php");
            die;
        }
    } else {
        $error = "Please enter valid information in all fields and agree to the terms and conditions.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Google tag (gtag.js) -->
<script src="../analytics.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="styles.css">

 
</head>
<body>
  <div class="full-screen-container">
 
 
    <div class="login-container">
      <h1 class="login-title">Sign Up</h1>
      <i class="fa-solid fa-arrow-left" id="openNav" onclick="location.href='../index.php'"></i>
      
      <form class="form" method="post">
     
        <div class="input-group success">
          
          <input id="username" type="text" name="username" required placeholder="username" autocomplete="username" maxlength="31">
        </div>
        
        <div class="input-group success">
          <input id="full_name" type="text" name="full_name" pattern=".{7,}" title="7 characters minimum" required placeholder="Full Name">
        </div>
        <div class="input-group error"> 
          <input id="password" type="password" name="password" pattern=".{8,}" title="8 characters minimum" required autocomplete="new-password" placeholder="Password">
        </div>
        <?php if(isset($error)): ?>
        <p class="form-error"><?php echo htmlspecialchars($error); ?></p> 
        <?php endif; ?>
        <div class="terms-row">
          <input type="checkbox" name="agree" id="agree" class="agree-checkbox" required>
          <label for="agree" class="agree-label">I agree to the <a href="agreemint.html" class="agree-link">terms and conditions</a>.</label>
        </div>
        <button type="submit" value="Signup" name="submit" class="login-button">Create Account</button>
        <p class="auth-link">Already registered? <a href="login.php">Login</a></p>
      </form>
    </div>
  </div>

  <script>
 document.getElementById('username').addEventListener('input', function(e) {
        let value = e.target.value;
       
        // Allow only lowercase letters, numbers, periods, and underscores
        value = value.replace(/[^a-z0-9._@]/g, '');

        e.target.value = value;
    });

    // Ensure that the input starts with '@' when the page loads
   
    
  </script>
</body>
</html>
