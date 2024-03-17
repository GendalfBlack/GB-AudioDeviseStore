<!DOCTYPE html>
<html lang="uk">
<head>
    <title>Product list</title>
    <link rel="stylesheet" href="../../MySite/public/css/styles.css">
</head>
<body>
    <header>
        <?php include (__DIR__ . '/../user/profile_navigation.php') ?>
        <script src="../../MySite/public/js/list.js"></script>
    </header>
    <h1>Product List</h1>
    <div class="container">
        <div class="sidebar">
            <h2>Categories</h2>
            <ul class="category-list"> </ul>
        </div>
        <div id="product-grid" class="product-grid">
            <?php
            require_once(__DIR__ . '/../../controllers/ProductController.php');
            $productController = new ProductController();

            $products = $productController->getAllProducts();

            echo '<script>';
            echo 'var products = ' . json_encode($products) . ';';
            echo '</script>';
            echo '<script src="../../MySite/public/js/categories.js" defer></script>';

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
                    echo '<form action="../app/controllers/add_to_basket.php" method="POST">';
                    echo '<input type="hidden" name="product_id" value="' . $product['product_id'] . '">';
                    echo '<input type="hidden" name="action" value="add">';
                    echo '<button class="product-actions-form-button" type="submit">Add to Basket</button>';
                    echo '</form>';
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products found</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>