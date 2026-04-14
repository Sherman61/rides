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
 

<style type="text/css">
.login-container{
  position: relative;
}

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
  color: wheat;
  display: inline-block;
  margin-top: 5px;
}

.agree-link {
  color: wheat;
  text-decoration: underline;
}

#openNav {
   
  font-weight: 900;
  position: absolute;
  left: 10px;
  top: 10px;
  font-size: 2.5em;
}
</style>
 
</head>
<body>
 
      <i class="fa-solid fa-arrow-left" id="openNav" onclick="location.href='../index.php'"></i>
     
 

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
