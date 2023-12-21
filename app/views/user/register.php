<!DOCTYPE html>
<html lang="uk">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../../MySite/public/css/styles.css"> <!-- Link to your CSS file -->
</head>
<body>
<header>
    <h1>Register</h1>
</header>
<main>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" class="register-form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Register" class="btn">
    </form>

    <?php
    if (isset($error)) {
        echo '<p class="error-message">' . $error . '</p>';
    }
    ?>
</main>
</body>
</html>

