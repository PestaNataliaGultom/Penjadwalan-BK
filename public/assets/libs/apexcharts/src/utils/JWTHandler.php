<?php
require_once '../vendor/autoload.php';
require_once '../config/jwt.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler {
    
    public static function generateToken($user_data) {
        $payload = array(
            "iss" => JWTConfig::$issuer,
            "aud" => JWTConfig::$audience,
            "iat" => time(),
            "exp" => time() + JWTConfig::$expire_time,
            "data" => array(
                "id" => $user_data['id'],
                "username" => $user_data['username'],
                "email" => $user_data['email'],
                "role" => $user_data['role'],
                "permissions" => $user_data['permissions']
            )
        );

        return JWT::encode($payload, JWTConfig::$secret_key, JWTConfig::$algorithm);
    }

    public static function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new Key(JWTConfig::$secret_key, JWTConfig::$algorithm));
            return (array) $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getTokenFromHeader() {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
        
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $matches[1];
        }
        
        return null;
    }
}
?>