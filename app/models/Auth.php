<?php
require_once '../config/database.php';
require_once '../config/config.php';

class Auth {
    private $connection;

    public function __construct() {
        $this->connection = getConnection();
    }

    public function login($data) {
        $username = $data['username'];
        $password = $data['password'];

        // Validación de usuario
        if ($username === 'admin' && $password === '1234') {
            $header = ['alg' => 'HS256', 'typ' => 'JWT'];
            $payload = [
                'iat' => time(),
                'exp' => time() + (60 * 60), // El token expira en 1 hora
                'username' => $username
            ];

            $jwt = $this->generateJWT($header, $payload, KEY);

            // Crear una cookie con el token, que expire en 5 minutos
            setcookie('auth_token', $jwt, time() + (5 * 60), "/", "", false, true); // "httpOnly" activado para mayor seguridad

            return [
                'message' => 'Autenticacion exitosa',
                'status' => true,
                'token' => $jwt
            ];
        } else {
            http_response_code(401);
            return [
                'message' => 'Credenciales invalidas',
                'status' => false,
            ];
        }
    }

    public function session() {
        $headers = apache_request_headers(); // Obtiene todos los encabezados
        if (isset($headers['Authorization'])) {
            // Si el encabezado Authorization existe
            $matches = [];
            // Usamos una expresión regular para extraer el token
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                $decoded = $this->verifyJWT($matches[1], KEY);

                if ($decoded) {
                    return ['message' => 'Acceso permitido', 'data' => $decoded, 'status' => true];
                } else {
                    return ['message' => 'Token invalido o expirado', 'status' => false];
                }
            }
        }else {
            http_response_code(401);
            return ['message' => 'No se proporciono el token'];
        }
    }

    // Función para generar el token
    public function generateJWT($header, $payload, $secret) {
        $header_encoded = $this->base64UrlEncode(json_encode($header)); // Codificar el header en base64
        $payload_encoded = $this->base64UrlEncode(json_encode($payload)); // Codificar el payload en base64
        $signature = hash_hmac('SHA256', "$header_encoded.$payload_encoded", $secret, true); // Crear la firma
        $signature_encoded = $this->base64UrlEncode($signature); // Codificar la firma en base64

        return "$header_encoded.$payload_encoded.$signature_encoded"; // Retornar el token completo
    }

    public function base64UrlEncode($data) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data)); // Reemplazar los caracteres no permitidos en base64
    } 

    public function verifyJWT($token, $secret) {
        $parts = explode('.', $token); 
        if (count($parts) !== 3) return false;
    
        list($header_encoded, $payload_encoded, $signature_provided) = $parts; 
    
        $signature = hash_hmac('SHA256', "$header_encoded.$payload_encoded", $secret, true); // Crear la firma
        $signature_verified = $this->base64UrlEncode($signature); // Codificar la firma en base64
    
        if ($signature_verified !== $signature_provided) return false;
    
        $payload = json_decode(base64_decode($payload_encoded), true); // Decodificar el payload
    
        if (isset($payload['exp']) && $payload['exp'] < time()) return false; // Verificar si el token ha expirado
    
        return $payload;
    }

    public function __destruct() {
        $this->connection->close();
    }
}
