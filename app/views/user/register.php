<!DOCTYPE html>
<html lang="uk">
<head>
    <title>Register</title>
</head>
<body>
<h1>Register</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Register">
</form>

<?php
if (isset($error)) {
    echo '<p style="color: red;">' . $error . '</p>';
}
?>
</body>
</html>

