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
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EJGP58HHQS"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-EJGP58HHQS');
</script>
<style type="text/css">
#button{
    padding: 10px;
    color: white;
    background-color: Lightblue;
    border: none;
}
::placeholder{
    color: #333;
    opacity: 1;
}

.agree-checkbox {
  width: 20px;
  height: 20px;
  margin-right: 10px;
}

.agree-label {
  font-size: 16px;
  color: #333;
  display: inline-block;
  margin-top: 5px;
}

.agree-link {
  color: blue;
  text-decoration: underline;
}
</style>
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
        <p style="color: red;"><?php echo $error; ?></p> 
        <?php endif; ?>
        <div class="input-group">
          <label for="agree" class="agree-label">I agree to the <a href="agreemint.html" class="agree-link">terms and conditions</a>.</label>
          <input type="checkbox" name="agree" id="agree" class="agree-checkbox" required>
        </div>
        <button id="button" type="submit" value="Signup" name="submit" class="login-button">Submit</button>
        <a href="login.php">Click to Login</a><br><br>
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
