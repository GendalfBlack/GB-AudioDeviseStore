<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../../models/User.php');

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userData = User::getInstance()->getUserById($userId);

    if ($userData) {
        ?>
            <!DOCTYPE html>
            <html lang="uk">
            <head>
                <title>User Profile</title>
            </head>
            <body>
            <h1>Welcome to Your Profile</h1>
            <p>Username: <?php echo $userData['username']; ?></p>
            <p>Email: <?php echo $userData['email']; ?></p>
            <a href="../../../../MySite/public/index.php">Back to Product List</a><br><br>
            <a href="../../../../MySite/app/views/user/logout.php">Logout</a>
            </body>
            </html>
        <?php
        } else {
            echo "User data not available";
        }
}else{
    echo "User id is not set";
}