<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Your Basket</title>
</head>
<body>
<h1>Your Basket</h1>
<p>Product added to basket!</p>

<!-- Display the list of products in the basket -->
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
    <?php
    $totalAmount = 0;
    /** @var ArrayObject $basketItems */
    foreach ($basketItems as $item): ?>
        <tr>
            <td><?php echo $item['product_name']; ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo $item['price']; ?></td>
            <td><?php echo $item['quantity'] * $item['price']; $totalAmount+= $item['quantity'] * $item['price'];?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p>Total Amount: <?php echo $totalAmount; ?></p>

<form action="order_complete.php" method="POST">
    <input type="hidden" name="order_id" value="123">
    <input type="submit" value="Complete Order">
</form>

<a href="../../public/index.php">Continue Shopping</a>
</body>
</html>
