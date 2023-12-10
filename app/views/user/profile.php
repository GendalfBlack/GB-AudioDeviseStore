<!DOCTYPE html>
<html lang="uk">
<head>
    <title>User Profile</title>
</head>
<body>
<h1>Welcome to Your Profile</h1>
<?php /** @var User $userData */ // tells PHPStorm that $userData is a User type
if ($userData): ?>
    <p>Username: <?php echo $userData['username']; ?></p>
    <p>Email: <?php echo $userData['email']; ?></p>
    <a href="<?php echo $_SERVER['REQUEST_URI']?>">Logout</a> <!-- Link for logout -->
<?php else: ?>
    <p>User data not available</p>
<?php endif; ?>
</body>
</html>
