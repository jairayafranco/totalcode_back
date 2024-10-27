<?php
require_once '../config/database.php';

class Order {
    private $connection;

    public function __construct() {
        $this->connection = getConnection();
    }

    public function getOrders($query) {
        try {
            $month = $query['month'] ?? null;
            $status = $query['status'] ?? null;

            if(isset($month) && isset($status)) {
                $getOrders = "SELECT * FROM orders WHERE MONTH(date_placed) = ? AND status = ?";
                $stmt = $this->connection->prepare($getOrders);
                $stmt->bind_param("is", $month, $status);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $getAllOrders = "SELECT * FROM orders";
                $result = $this->connection->query($getAllOrders);
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        } catch (\Throwable $th) {
            return ['error' => $th->getMessage()];
        }
    }

    public function __destruct() {
        $this->connection->close();
    }
}