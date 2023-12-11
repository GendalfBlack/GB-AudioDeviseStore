<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
</head>
<body>
<h1>Product Details</h1>
<?php /** @var Product $productData */
if ($productData): ?>
    <h2><?php echo $productData['product_name']; ?></h2>
    <p>Category: <?php echo $productData['category_name']; ?></p>
    <p>Price: $<?php echo $productData['price']; ?></p>
    <p>Description: <?php echo $productData['description']; ?></p>
    <a href="../../../../MySite/public/index.php">Back to Product List</a>
<?php else: ?>
    <p>Product details not available</p>
<?php endif; ?>
</body>
</html>

