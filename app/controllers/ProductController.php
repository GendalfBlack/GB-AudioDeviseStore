<?php
class ProductController {
    public function list() {
        // Logic for displaying a list of products
        include('../views/product/list.php');
    }

    public function details() {
        // Logic for displaying product details
        include('../views/product/details.php');
    }

    // Other product-related methods...
}

