<?php 
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con); 

?>

<!DOCTYPE html>
<html lang="en">
<head>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-EJGP58HHQS');
</script>
 
<meta charset="UTF-8">
<script src="active_players.js"></script> 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
    .center {
        text-align: center;
    }
    h1 {
        margin-bottom: 20px;
        font-size: 2.5em;
        color: #4CAF50;
    }
    p {
        font-size: 1.2em;
        margin-bottom: 20px;
    }
    .profile-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px;
    }
    .profile-icon {
        width: 100px;
        height: 100px; 
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
        border: 2px solid #4CAF50;
    }
    .button-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }
    .button {
        background-color: #4CAF50;
        color: white;
        padding: 15px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 1.2em;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        width: 100%;
        max-width: 200px;
        box-sizing: border-box;
    }
    .button:hover {
        background-color: #45a049;
    }
    .logout-button {
        background-color: #f44336;
        margin-top: 20px;
    }
    .logout-button:hover {
        background-color: #d32f2f;
    }
    @media (max-width: 600px) {
        h1 {
            font-size: 2em;
        }
        p {
            font-size: 1em;
        }
        .button {
            font-size: 1em;
            padding: 12px 20px;
        }
    }
    .fa-user {
  position: fixed;
  top: 10px;
  right: 10px;
  margin: 10px;
  font-size: 48px;
  color: #000;
} 
.animate__animated, .animate__pulse{
    /* animation: pulse; referring directly to the animation's @keyframe declaration */
  animation-duration: 5s; /* don't forget to set a duration! */
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>
<body>

    <h1 class="center">Welcome to Shiyas website</h1>
    
    <div class="profile-container"> 
        <?php 
        // Check if the user has a profile image URL
        $profile_image_url = !empty($user_data['profile_image_url']) ? htmlspecialchars($user_data['profile_image_url']) : 'images/profile.png';
        ?>
        <img src="<?php echo $profile_image_url; ?>" alt="Profile Image" class="profile-icon">
        <p>Hello, <?php echo htmlspecialchars($user_data['full_name']); ?>! Your username is <?php echo htmlspecialchars($user_data['username']); ?></p>
    </div>

    <!-- <p>Challenges coming soon!</p>
 -->
    <div class="button-container ">
        <a href="../index.php" class="button">view rides</a>
        <a href="../add.php" class="button">add a ride</a>
        <!-- <a href="profile.php" class="button">Profile</a> -->
        <i class="fa-solid fa-user animate__animated animate__pulse"  alt="profile" title="profile" onclick="location.href='profile.php'"></i>
        <a href="logout.php" class="button logout-button">Logout</a>
    </div>

</body>
</html>
