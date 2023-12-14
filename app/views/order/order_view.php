<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Your Basket</title>
</head>
<body>
<h1>Your Basket</h1>
    <?php
    require_once(__DIR__ . '/../../controllers/OrderController.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $totalAmount = 0;

    $orderController = OrderController::getInstance();
    $basketItems = $orderController->getBasketItems($_SESSION['user_id']);

    if (count($basketItems) > 0){
        foreach ($basketItems as $item):
     ?>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $item['product_name']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td><?php echo $item['quantity'] * $item['price']; $totalAmount+= $item['quantity'] * $item['price'];?></td>
            </tr>
        </tbody>
    </table>
    <p>Total Amount: <?php echo $totalAmount; ?></p>

    <form action="order_complete.php" method="POST">
        <input type="hidden" name="order_id" value="123">
        <input type="submit" value="Complete Order">
    </form>
    <?php endforeach;
    }else{
        echo "<p>Your basket is empty!</p>";
    }
    ?>

<a href="/MySite/public/index.php">Continue Shopping</a>
</body>
</html>
