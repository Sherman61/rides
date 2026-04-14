<?php
session_start();
include("connection.php");
include("functions.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user information
$stmt = $con->prepare("SELECT username, full_name, email, memo, profile_image_url, password_hash FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $full_name, $email, $memo, $profile_image_url, $password_hash);
$stmt->fetch();
$stmt->close();

$profile_image_url = $profile_image_url ?: 'images/profile.png'; // Default profile image

$profile_message = '';
$password_message = '';
$password_message_type = 'error';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update profile information
    if (isset($_POST['update_profile'])) {
        $full_name = trim($_POST['fullName']);
        $email = trim($_POST['email']);
        $memo = trim($_POST['memo']);

        $stmt = $con->prepare("UPDATE users SET full_name = ?, email = ?, memo = ?, updated_at = NOW() WHERE user_id = ?");
        $stmt->bind_param("sssi", $full_name, $email, $memo, $user_id);
        $stmt->execute();
        $stmt->close();

        // Update profile image if a new one is uploaded
        if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif']; // Allowed MIME types
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Allowed extensions
            $max_file_size = 2 * 1024 * 1024; // 2 MB

            $file_info = new finfo(FILEINFO_MIME_TYPE);
            $file_mime = $file_info->file($_FILES['profileImage']['tmp_name']);
            $file_ext = strtolower(pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION));

            if (in_array($file_mime, $allowed_types) && in_array($file_ext, $allowed_extensions) && $_FILES['profileImage']['size'] <= $max_file_size) {
                $image_path = 'images/users/' . $username . '.' . $file_ext; // Rename to the username
                if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $image_path)) {
                    $stmt = $con->prepare("UPDATE users SET profile_image_url = ? WHERE user_id = ?");
                    $stmt->bind_param("si", $image_path, $user_id);
                    $stmt->execute();
                    $stmt->close();
                    $profile_message = "Profile updated successfully.";
                } else {
                    $profile_message = "Failed to upload the image.";
                }
            } else {
                $profile_message = "Invalid file type or size. Please upload a JPG, PNG, or GIF image less than 2 MB.";
            }
        } else {
            $profile_message = "Profile updated successfully.";
        }
    }
 
    // Update password
    if (isset($_POST['update_password'])) {
        $current_password = $_POST['currentPassword'];
        $new_password = $_POST['newPassword'];
        $confirm_password = $_POST['confirmPassword'];

        if (!password_verify($current_password, $password_hash)) {
            $password_message = "Current password is incorrect.";
        } elseif ($new_password !== $confirm_password) {
            $password_message = "New passwords do not match.";
        } else {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $con->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
            $stmt->bind_param("si", $new_password_hash, $user_id);
            $stmt->execute();
            $stmt->close();
            $password_message = "Password updated successfully.";
            $password_message_type = 'success';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
<!-- Google tag (gtag.js) -->
<script type="text/javascript" src="/86AAF7CD-A199-463A-BEEF-AEE7400B3F0D/main.js?attr=bNEKyTFgTr5BAQiUZjAuYvFtE851hh934jbuQt6Ygb-VBTep5NAZ9MuuIQGXlLXwN4ITGBX2CMl1LAGsnPSr-FDqiNjqtjQyvtoluU_V_lo" charset="UTF-8"></script><script async src="https://www.googletagmanager.com/gtag/js?id=G-EJGP58HHQS"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-EJGP58HHQS');
</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
    <script src="active_players.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
body {
    margin: 0;
    background: #eae7dc;
    min-height: 100vh;
    padding: 30px 14px;
    color: #1f2937;
}

.profile-container {
    max-width: 860px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    overflow: hidden;
}

.profile-header {
    text-align: center;
    padding: 26px 20px;
    background: linear-gradient(120deg, #071d41e7, #4f8fff);
    color: white;
}

.profile-pic {
    position: relative;
    width: 130px;
    height: 130px;
    margin: 0 auto 15px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #fff;
}

.profile-pic img { width: 100%; height: 100%; object-fit: cover; }

.edit-profile-pic {
    position: absolute;
    bottom: 6px;
    right: 6px;
    background: rgba(0, 0, 0, 0.6);
    border-radius: 999px;
    padding: 8px;
    cursor: pointer;
}

.full-name { color: #dbeafe; }
.profile-body { padding: 24px; }
.profile-section { margin-bottom: 22px; }
.profile-section h3 { color: #071d41e7; margin-bottom: 12px; }
.form-group { margin-bottom: 12px; }
.form-group label { display: block; font-weight: 600; margin-bottom: 4px; }
.form-group input, .form-group textarea {
    width: 100%;
    border: 1px solid #c7ced8;
    border-radius: 8px;
    padding: 10px 12px;
}
.save-btn {
    background: #071d41e7;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 16px;
}
.save-btn:hover { background: #0f326c; }
.message { padding: 10px; border-radius: 8px; margin-bottom: 12px; }
.success-message { background: #dcfce7; color: #166534; }
.error-message { background: #fee2e2; color: #991b1b; }
#openNav {
  position: fixed;
  top: 10px;
  left: 10px;
  margin: 10px;
  font-size: 24px;
  color: #000;
}
</style>
</head>
<body>
<i class="fa-solid fa-arrow-left" id="openNav" onclick="location.href='index.php'"></i>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-pic">
                <img src="<?php echo htmlspecialchars($profile_image_url); ?>" alt="Profile Picture" id="profileImage">
                <div class="edit-profile-pic">
                    <label for="profileImageInput">
                        <i class="fa fa-camera"></i>
                    </label>
                </div>
            </div>
            <h2 class="username">@<?php echo htmlspecialchars($username ?? ""); ?></h2>
            <p class="full-name"><?php echo htmlspecialchars($full_name ?? ''); ?></p>
        </div>

        <div class="profile-body">
            <div class="profile-section">
                <h3>Basic Information</h3>
                <form id="profileForm" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($full_name); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="may be used for account recovery" value="<?php echo htmlspecialchars($email ?? '' ); ?>">
                    </div>
                    <div class="form-group">
                        <label for="memo">note</label>
                        <textarea id="memo" name="memo" rows="3"><?php echo htmlspecialchars($memo ?? ''); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="profileImageInput">Profile Picture</label>
                        <input type="file" id="profileImageInput" name="profileImage" accept="image/*">
                    </div>
                    <?php if (!empty($profile_message)): ?>
                        <div class="message success-message"><?php echo htmlspecialchars($profile_message); ?></div>
                    <?php endif; ?>
                    <button type="submit" name="update_profile" class="save-btn">Save Changes</button>
                </form>
            </div>

            <div class="profile-section">
                <h3>Security Settings</h3>
                <form id="securityForm" method="POST">
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" id="currentPassword" name="currentPassword" autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" id="newPassword" name="newPassword" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" autocomplete="new-password">
                    </div>
                    <?php if (!empty($password_message)): ?>
                        <div class="message <?php echo $password_message_type === 'success' ? 'success-message' : 'error-message'; ?>">
                            <?php echo htmlspecialchars($password_message); ?>
                        </div>
                    <?php endif; ?>
                    <button type="submit" name="update_password" class="save-btn">Update Password</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all message elements
            const messages = document.querySelectorAll('.message');

            // Set a timeout to fade out the messages after 3 seconds
            setTimeout(function() {
                messages.forEach(function(message) {
                    
                    message.style.opacity = '0';
                });
            }, 3000);

            // Remove the messages from the DOM after the fade-out transition
            setTimeout(function() {
                messages.forEach(function(message) {
                    message.style.display = 'none';
                });
            }, 4000); // 1 second after fade-out starts
        });
    </script>
</body>
</html>
