<?php
if (!isset($_SESSION['user_id'])){
    /* @var UserController $userController */
    if ($userController->decideShowLoginLink()){
        echo '<a href="'.$_SERVER['REQUEST_URI'].'?action=login">Login</a>';
    }
}
else{
    echo '<a href="../../../../MySite/app/views/user/profile.php">Profile</a>';
    echo "<br><br>";
    echo '<a href="../../../../MySite/app/views/order/order_view.php">Shoping Basket</a>';
}