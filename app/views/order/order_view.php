<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Your Basket</title>
    <link rel="stylesheet" href="<?php echo "../../../MySite/public/css/styles.css";?>">
    <link rel="stylesheet" href="<?php echo "../../../../MySite/public/css/styles.css";?>">
</head>
<body>
<header>
    <?php include (__DIR__ . '/../user/profile_navigation.php') ?>
    <script src="../../public/js/search.js" defer></script>
</header>
<h1>Your Basket</h1>
<?php
require_once(__DIR__ . '/../../controllers/OrderController.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$totalAmount = 0;

$orderController = OrderController::getInstance();
$basketItems = $orderController->getBasketItems($_SESSION['user_id']);
$orderId = $orderController->getUserOrder($_SESSION['user_id']);

if (count($basketItems) > 0):
    ?>
    <table class="basket-table">
        <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($basketItems as $item): ?>
            <tr>
                <td>
                    <img src="https://placehold.co/300?text=Placeholder&font=roboto" alt="Product Image" class="product-thumbnail">
                    <?php echo $item['product_name']; ?>
                </td>
                <td class="center">
                    <div class="quantity-container">
                        <form action="add_to_basket.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                            <input type="hidden" name="action" value="decrement">
                            <button type="submit" class="quantity-btn decrement-btn">-</button>
                        </form>
                        <span class="quantity"> <?php echo $item['quantity']; ?> </span>
                        <form action="add_to_basket.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                            <input type="hidden" name="action" value="increment">
                            <button type="submit" class="quantity-btn increment-btn">+</button>
                        </form>
                    </div>
                </td>
                <td>$<?php echo $item['price']; ?></td>
                <td>$<?php $total = $item['quantity'] * $item['price']; echo $total; $totalAmount += $total; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total Amount:</strong></td>
            <td><strong>$<?php echo $totalAmount; ?></strong></td>
        </tr>
        </tbody>
    </table>
    <form action="order_complete.php" method="POST">
        <input type="hidden" name="order_id" value="123">
        <input type="submit" value="Complete Order" class="complete-order-btn">
    </form>
    <form action="/MySite/public/index.php?action=decline" method="GET">
        <input type="hidden" name="action" value="decline_order">
        <input type="hidden" name="order_id" value="<?php echo $orderId; ?>">
        <input type="submit" value="Decline Order" class="decline-order-btn">
    </form>
<?php else: ?>
    <p>Your basket is empty!</p>
<?php endif; ?>
<a href="/MySite/public/index.php" class="continue-shopping-link">Continue Shopping</a>
</body>
</html>
