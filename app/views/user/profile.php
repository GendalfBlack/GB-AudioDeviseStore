<!DOCTYPE html>
<html lang="uk">
<head>
    <title>User Profile</title>
</head>
<body>
    <h1>Welcome to Your Profile</h1>
    <p>Username: <?php echo isset($user['username']) ? $user['username'] : ''; ?></p>
    <p>Email: <?php echo isset($user['email']) ? $user['email'] : ''; ?></p>
</body>
</html>
