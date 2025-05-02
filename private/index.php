<?php
include_once '../utils/jwt.php';

$token = $_COOKIE['token'] ?? '';
if (validate_jwt($token)) {
    echo "Chào mừng đến khu vực riêng tư!\n FLAG{found_secret_console}";
} else {
    http_response_code(401);
    echo "Truy cập không hợp lệ.";
}
?>