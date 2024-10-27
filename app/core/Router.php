<?php

class Router {
    private $routes = [];

    // Registrar una ruta GET
    public function get($route, $action) {
        $this->routes['GET'][$route] = $action;
    }

    // Registrar una ruta POST
    public function post($route, $action) {
        $this->routes['POST'][$route] = $action;
    }

    // Manejar la solicitud
    public function dispatch($uri, $method) {
        // Extraer solo el path (ruta base) sin los queryParams
        $baseUri = parse_url($uri, PHP_URL_PATH);

        // Verificar si la ruta y el método están registrados
        if (isset($this->routes[$method][$baseUri])) {
            // Obtener el controlador y método
            list($controllerName, $controllerMethod) = explode('@', $this->routes[$method][$baseUri]);
            $controllerFile = '../app/controllers/' . $controllerName . '.php';

            // Obtener los parámetros de la query string
            if($method === 'GET') {
                $params = $_GET;
            } else {
                $params = $_POST;
            }

            // Asegurarse de que el controlador exista
            if(file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new $controllerName(); // Crear una instancia del controlador
                return $controller->$controllerMethod($params); // Llamar al método del controlador
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Controlador no encontrado']);
            }
        } else {
            // Error si la ruta no existe
            http_response_code(404);
            echo json_encode(['error' => 'Ruta no encontrada']);
        }
    }
}
