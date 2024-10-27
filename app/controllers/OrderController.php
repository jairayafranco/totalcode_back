<?php
require_once '../app/models/Order.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    public function fetchOrders($queryParams) {
        $data = $this->orderModel->getOrders($queryParams);
        echo json_encode($data);
    }
}
