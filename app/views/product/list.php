 <!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
</head>
<body>
<?php
    include (__DIR__ . '/../user/profile_navigation.php')
?>
<h1>Product List</h1>

<?php
require_once(__DIR__ . '/../../controllers/ProductController.php');
$productController = new ProductController();

$products = $productController->getAllProducts();

if ($products && count($products) > 0) {
    foreach ($products as $product) {
        echo "<h2>{$product['product_name']}</h2>";
        echo "<p>Category: {$product['category_name']}</p>";
        echo "<p>Price: $".$product['price']."</p>";

        echo "<a href=".$_SERVER['REQUEST_URI']."?action=view_product&id={$product['product_id']}>View Details</a>";
        echo "<br><br>";
        echo "<a href='../app/controllers/add_to_basket.php?product_id=".$product['product_id']."'>Add to Basket</a>";

    }
} else {
    echo "<p>No products found</p>";
}
?>
</body>
</html>
