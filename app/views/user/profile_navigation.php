<div class="logo">
    ShopName
</div>
<div class="search-container">
    <input type="text" placeholder="Search..." class="search-input">
    <button class="search-btn">Search</button>
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
            echo '<a href="../../../../MySite/app/views/order/order_view.php" class="nav-link">Shopping Basket</a>';
        }
    ?>
</div>