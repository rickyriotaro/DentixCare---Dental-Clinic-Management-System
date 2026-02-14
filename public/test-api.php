<?php
/**
 * Test API Login Endpoint
 * Lihat detail error response
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization');
header('Content-Type: application/json');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

echo json_encode([
    'status' => 'ok',
    'message' => 'API test endpoint working',
    'server_info' => [
        'php_version' => phpversion(),
        'https' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'host' => $_SERVER['HTTP_HOST'] ?? 'unknown',
        'method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
    ],
    'timestamp' => date('Y-m-d H:i:s')
]);
?>
