<?php
require_once(__DIR__ . '/../models/Product.php');
require_once(__DIR__ . '/../config.php');
class ProductController {
    /**
     * @var Product
     */
    private $productModel;

    public function __construct() {
        // Instantiate Product model when creating a ProductController instance
        $this->productModel = new Product();
    }
    public function viewProductDetails($productId) {
        // Fetch product details from the Product model
        $productData = $this->productModel->getProductById($productId);

        // Include the details view file and pass the product data
        include(__DIR__ . '/../views/product/details.php');
    }
    public function getAllProducts() {
        // Fetch all products from the Product model
        return $this->productModel->getAllProducts();
    }
}

