<div class="logo">
    ShopName
</div>
<div class="search-container" id="search-container">
    <input type="text" id="search-input" placeholder="Search..." class="search-input">
    <button id="search-btn" class="search-btn">Search</button>
    <button id="clear-btn" class="search-btn">Clear</button>
</div>
<div class="nav-links">
    <?php
    require_once(__DIR__ . '/../../controllers/UserController.php');
        if (!isset($_SESSION['user_id'])) {
            /* @var UserController $userController */
            $userController = UserController::getInstance();
            if ($userController->decideShowLoginLink()) {
                echo '<a href="' . $_SERVER['REQUEST_URI'] . '?action=login" class="nav-link">Login</a>';
                echo '<a href="' . $_SERVER['REQUEST_URI'] . '?action=register" class="nav-link">Register</a>';
            }
        } else {
            echo '<a href="../../../../MySite/app/views/user/profile.php" class="nav-link">Profile</a>';
            echo '<a href="../app/controllers/add_to_basket.php" class="nav-link">Shopping Basket</a>';
        }
    ?>
</div>