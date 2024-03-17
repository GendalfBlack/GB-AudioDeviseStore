<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <link rel="stylesheet" href="../../MySite/public/css/styles.css">
</head>
<body>
<header>
    <?php include (__DIR__ . '/../user/profile_navigation.php') ?>
</header>
<h1>Product Details</h1>
<?php /** @var Product $productData */
if ($productData): ?>
    <div class="product-details-page">
        <h2><?php echo $productData['product_name']; ?></h2>
        <div class="image-carousel">
            <img src="https://placehold.co/300?text=Placeholder&font=roboto" alt="Product Image Placeholder" class="main-image">
            <div class="carousel-controls">
                <button class="prev-btn" disabled>&lt;</button>
                <button class="next-btn" disabled>&gt;</button>
            </div>
        </div>
        <p>Category: <?php echo $productData['category_name']; ?></p>
        <p class='product-price'>Price: $<?php echo $productData['price']; ?></p>
        <p>Description: <?php echo $productData['description']; ?></p>
        <a href="../../../../MySite/public/index.php" class="back-btn">Back to Product List</a>
    </div>
<?php else: ?>
    <p>Product details not available</p>
<?php endif; ?>
</body>
</html>
