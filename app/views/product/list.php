<!DOCTYPE html>
<html lang="uk">
<head>
    <title>Product list</title>
    <link rel="stylesheet" href="../../MySite/public/css/styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <?php include (__DIR__ . '/../user/profile_navigation.php') ?>
    </header>
    <h1>Product List</h1>
    <div class="product-grid">
        <?php
        require_once(__DIR__ . '/../../controllers/ProductController.php');
        $productController = new ProductController();

        $products = $productController->getAllProducts();

        if ($products && count($products) > 0) {
            foreach ($products as $product) {
                echo "<div class='product'>";
                echo "<img src='https://placehold.co/300?text=Placeholder&font=roboto' alt='Product Image Placeholder'>";
                echo "<div class='product-details'>";
                echo "<h2>{$product['product_name']}</h2>";
                echo "<p>Category: {$product['category_name']}</p>";
                echo "<p class='product-price'>Price: $".$product['price']."</p>";
                echo "<div class='product-actions'>";
                echo "<a href=".$_SERVER['REQUEST_URI']."?action=view_product&id=".$product['product_id'].">View Details</a>";
                echo '<a href="../app/controllers/add_to_basket.php?product_id='.$product['product_id'].'">Add to Basket</a>';
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No products found</p>";
        }
        ?>
    </div>
</body>
</html>