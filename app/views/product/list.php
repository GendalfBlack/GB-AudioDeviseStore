<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
</head>
<body>
<h1>Product List</h1>
<?php
// Initialize the ProductController
require_once(__DIR__ . '/../app/controllers/ProductController.php');
$productController = new ProductController();

// Get all products
$products = $productController->getAllProducts();

if ($products && count($products) > 0) {
    foreach ($products as $product) {
        // Display product information and link to view details
        echo "<h2>{$product['product_name']}</h2>";
        echo "<p>Category: {$product['category_name']}</p>";
        echo "<p>Price: ${$product['price']}</p>";
        // Other product details if needed

        // Link/button to view details of this product
        echo "<a href=\"details.php?id={$product['product_id']}\">View Details</a>";
    }
} else {
    echo "<p>No products found</p>";
}
?>
</body>
</html>
