<?php
class OrderController {
    public function create() {
        // Logic for creating an order
        include('../views/order/create.php');
    }

    public function view() {
        // Logic for viewing an order
        include('../views/order/view.php');
    }

    // Other order-related methods...
}

