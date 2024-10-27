<?php
require_once '../app/core/Router.php';

header('Content-Type: application/json'); // Tipo de contenido JSON
header("Access-Control-Allow-Origin: *"); // Permite todas las solicitudes
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Encabezados permitidos

$request_uri = $_SERVER['REQUEST_URI']; // Obtiene la URL de la peticion
$base_path = dirname($_SERVER['SCRIPT_NAME']);  // Obtiene el prefijo "/totalcode_back/public"
$request_uri = substr($request_uri, strlen($base_path)); // Elimina el prefijo de la URL
$method = $_SERVER['REQUEST_METHOD']; // Obtiene el metodo de la peticion

$router = new Router(); // Crear una instancia de Router
require_once '../app/routes/api.php'; // Incluir las rutas
$router->dispatch($request_uri, $method); // Despachar la solicitud
