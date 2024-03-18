<?php
require_once(__DIR__ . '/../models/Product.php');
require_once(__DIR__ . '/../config.php');
class ProductController {
    /**
     * @var Product
     */
    private $productModel; // Модель продукту

    public function __construct() {
        // Створення екземпляру моделі продукту при створенні об'єкта ProductController
        $this->productModel = new Product();
    }

    public function viewProductDetails($productId) {
        // Отримання даних про продукт з моделі продукту
        $productData = $this->productModel->getProductById($productId);

        // Підключення файлу вигляду з деталями продукту та передача даних про продукт
        include(__DIR__ . '/../views/product/details.php');
    }

    public function getAllProducts() {
        // Отримання всіх продуктів з моделі продукту
        return $this->productModel->getAllProducts();
    }
}


