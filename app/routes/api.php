<?php
$router->get('/api/orders', 'OrderController@fetchOrders');
$router->post('/api/auth/login', 'AuthController@login');
$router->post('/api/auth/check', 'AuthController@verifyJWT');
