<?php
require_once '../app/models/Auth.php';

class AuthController {
    private $authModel;

    public function __construct() {
        $this->authModel = new Auth();
    }

    public function login($loginData) {
        $data = $this->authModel->login($loginData);
        echo json_encode($data);
    }

    public function verifyJWT() {
        $data = $this->authModel->session();
        echo json_encode($data);
    }
}
